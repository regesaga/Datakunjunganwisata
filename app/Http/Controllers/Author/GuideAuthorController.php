<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\PaketWisata;
use App\Models\Wisatawan;
use App\Models\Company;
use App\Models\Article;
use App\Models\BanerPromo;
use App\Models\Tag;
use App\Models\User;
use App\Models\Htpaketwisata;
use App\Models\Fasilitas;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Traits\MediaUploadingTrait;

class GuideAuthorController extends Controller
{

    use MediaUploadingTrait;
        
    public function index()
    {   
        $hash=new Hashids();
        $company = null;
        $guide = null;
        $htpaketwisata = null;
    
        if ($this->hasCompany()) {
            $company = auth()->user()->company;
        }
    
        $id = Auth::id();
        $guide = PaketWisata::where('created_by_id', $id)->get();
        $htpaketwisata = Htpaketwisata::all();
    
        return view('account.guide.user-guide', compact('guide', 'company','hash', 'htpaketwisata'))->with([
            'hash' => $hash,
            'guide' => $guide,
            'company' => $company,
            'htpaketwisata' => $htpaketwisata
        ]);
    }


   

    

    public function changePasswordView()
    {
        $user = auth()->user(); // Get the authenticated user

        return view('account.guide.ganti-password');
    }

    public function changePassword(Request $request)
    {
        if (!auth()->user()) {
            Alert::toast('Not authenticated!', 'success');
            return redirect()->back();
        }

        //check if the password is valid
        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ]);

        $authUser = auth()->user();
        $currentP = $request->current_password;
        $newP = $request->new_password;
        $confirmP = $request->confirm_password;

        if (Hash::check($currentP, $authUser->password)) {
            if (Str::of($newP)->exactly($confirmP)) {
                $user = User::find($authUser->id);
                $user->password = Hash::make($newP);
                if ($user->save()) {
                    Alert::toast('Password Diganti!', 'success');
                    return redirect()->route('account.guide.user-guide');
                } else {
                    Alert::toast('Something went wrong!', 'warning');
                }
            } else {
                Alert::toast('Passwords do not match!', 'info');
            }
        } else {
            Alert::toast('Incorrect Password!', 'info');
        }
        return redirect()->back();
    }

  
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }



    public function create()
    {
        if (auth()->user()->company) {
            Alert::toast('Anda Sudah Memiliki Perusahaan!', 'info');
            return $this->edit();
        }
        return view('account.guide.company.create');
    }

  
    
    public function store(Request $request)
{
    $userId = Auth::id();

    // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required',
        'title' => 'required',
        'ijin' => 'required',
        'phone' => 'required|max:13', // Panjang karakter maksimum yang diizinkan adalah 13
    ]);

    // Cek apakah user ID sudah ada dalam database
    $existingUser = Company::where('user_id', $userId)->first();
    if ($existingUser) {
        // Jika user ID sudah ada, berikan pesan error atau lakukan tindakan lain sesuai kebutuhan Anda
        return redirect()->back()->withErrors('User ID Sudah Digunakan');
    }

    // Jika user ID belum ada dan data valid, lanjutkan untuk menyimpan data
    $validatedData['user_id'] = $userId;
    $company = Company::create($validatedData);
    return redirect()->route('account.guide.user-guide');
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     public function edit()
    {
        $company = auth()->user()->company;
        return view('account.guide.company.edit', compact('company'))->with([
            'company' => $company
        ]);
    }
   
   
    public function update(Request $request, $companyId)
    {
        $userId = Auth::id();
    
        $validatedData = $request->validate([
            'nama' => 'required',
            'title' => 'required',
            'ijin' => 'required',
            'phone' => 'required|max:13', // Panjang karakter maksimum yang diizinkan adalah 13
        ]);
    
        // Perbarui data perusahaan jika ID ditemukan
        $companyData = Company::find($companyId);
        if ($companyData) {
            // Pastikan pengguna yang sedang login adalah pemilik perusahaan
            if ($companyData->user_id == $userId) {
                $companyData->nama = $validatedData['nama'];
                $companyData->title = $validatedData['title'];
                $companyData->ijin = $validatedData['ijin'];
                $companyData->phone = $validatedData['phone'];
                $companyData->save();
            }
        }
    
        return redirect()->route('account.guide.user-guide')->with('success', 'Data perusahaan berhasil diperbarui');
    }

    

    protected function hasCompany()
    {
        return auth()->user()->company !== null;
    }
    
    protected function hasGuide()
    {
        return auth()->user()->company !== null && auth()->user()->company->paketwisata !== null;
    }
    

    public function createGuide()
    {
        $company = auth()->user()->company;
    
        return view('account.guide.guide.create', compact('company'));
    }



    public function storeGuide(Request $request)
{
    $company_id = Auth::user()->company->id;
    $data = $request->all();

        try {

            \DB::beginTransaction();

            $validatedData['company_id'] = $company_id;
            $guide = new PaketWisata($request->all());
            $guide->company_id = $company_id;
            $guide->save();

            foreach ($request->input('photos', []) as $file) {
                $guide->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     

            if ($request->jenis) {
                foreach ($data['jenis'] as $item => $value) {
                    $data2 = array(
                        'paketwisata_id' => $guide->id,
                        'jenis' => $data['jenis'][$item],
                        'harga' => $data['harga'][$item],
                    );
                    Htpaketwisata::create($data2);
                }
            }

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.guide.user-guide')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            

            public function destroyguide(Request $request,$guide)
                    {
                        $hash=new Hashids();
                        $guide = PaketWisata::find($hash->decodeHex($guide));
                        $guide->delete();
                        if (count($guide->photos) > 0) {
                            foreach ($guide->photos as $media) {
                                if (!in_array($media->file_name, $request->input('photos', []))) {
                                    $media->delete();
                                }
                            }
                        }
                
                        return back();
                    }
  
    public function editguide()
    {
        $company_id = auth()->user()->company->id;
        $guide = PaketWisata::where('company_id', $company_id)->first();
    
        return view('account.guide.guide.edit', compact('guide'));
    }
    
    public function showguide($guide)
    {
        $hash=new Hashids();
        $guide = PaketWisata::find($hash->decodeHex($guide));
        $htpaketwisata = $guide->htpaketwisata;
        return view('account.guide.guide.show', compact('guide','hash','htpaketwisata'));
    }

    public function guideupdate(Request $request, $guide)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $guide = PaketWisata::with('htpaketwisata')->find($guide);
        Htpaketwisata::where('paketwisata_id', $guide->id)->delete();
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $guide->update($request->all());

        if (count($guide->photos) > 0) {
            foreach ($guide->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $guide->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $guide->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           
        if ($request->jenis && isset($data['jenis'])) {
            foreach ($data['jenis'] as $item => $value) {
                $data2 = array(
                    'paketwisata_id' => $guide->id,
                    'jenis' => $data['jenis'][$item],
                    'harga' => $data['harga'][$item],
                );
                Htpaketwisata::create($data2);
            }
        }
        

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.guide.user-guide')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            
            public function getTag()
            {
                $hash=new Hashids();
                $tag = Tag::all();
                return view('account.wisata.tag.index', compact('tag','hash'));
            }
        
        
        
            public function createTag()
            {
            return view('account.wisata.tag.create');
            }
        
            public function storeTag(Request $request)
            {
            $request->validate([
            'nama' => 'required',
            ]);
        
            Tag::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-')
            ]);
            $request->session()->flash('sukses', '
            <div class="alert alert-success" role="alert">
            Data berhasil ditambahkan
            </div>
            ');
            return redirect()->route('account.wisata.tag.index');
        }
        
        
                public function editTag($tag)
                {
                $hash=new Hashids();
                $tag = Tag::find($hash->decodeHex($tag));
                return view('account.wisata.tag.edit', compact( 'tag','hash'))->with([
                'tag' => $tag,
                'hash' => $hash
                ]);
                }
        
        
                public function updateTag(Request $request, $id)
                {
                $hash=new Hashids();
                $request->validate([
                'nama' => 'required',
                ]);
        
                Tag::whereId($hash->decodeHex($id))->update([
                'nama' => $request->nama,
                'slug' => Str::slug($request->nama, '-')
                ]);
        
                $request->session()->flash('sukses', '
                <div class="alert alert-success" role="alert">
                Data berhasil diubah
                </div>
                ');
                return redirect()->route('account.wisata.tag.index');
                }
        
        
                public function destroyTag(Request $request,$tag)
                {
                    $hash=new Hashids();
                    $tag = Tag::find($hash->decodeHex($tag));
                    File::delete('upload/tag/' . $tag->nama);
                    $tag->delete();
        
        
                    return back();
                }
        
                public function getAllArticle()
                {
                $hash=new Hashids();
                $id = Auth::id();
                $article = Article::where('created_by_id', $id)->get();
                $tag = Tag::all();
                return view('account.guide.article.index', compact('article','hash','tag'))->with([
                'hash' => $hash,
                'tag' => $tag
                ]);
                }
        
                public function createarticle()
                {
                $hash=new Hashids();
                $tag = Tag::all();
                return view('account.guide.article.create', compact( 'tag', 'hash'))->with([
                'tag' => $tag,
                'hash' => $hash
                ]);
                }
        
        
                public function storearticle(Request $request)
                {
                $request->validate([
                'judul' => 'required',
                'sampul' => 'required|mimes:jpg,jpeg,png',
                'konten' => 'required',
                'tag' => 'required',
                ]);
                if(!$request->active){
                $request->merge([
                'active' => 0
                ]);
                }
                $sampul = time() .'-' .$request->sampul->getClientOriginalName();
                $request->sampul->move('upload/article', $sampul);
        
                Article::create([
                'sampul' => $sampul,
                'judul' => $request->judul,
                'konten' => $request->konten,
                'slug' => Str::slug($request->judul, '-'),
                'created_by_id' => Auth::user()->id
                ])->tag()->attach($request->tag);
        
                Alert::success('Sukses', 'Data berhasil ditambahkan');
                return redirect()->route('account.guide.article.index');
                }
        
        
        
                public function showarticle($article)
                {
                    $hash=new Hashids();
                    $article = Article::find($hash->decodeHex($article));
                    return view('account.guide.article.show', compact('article','hash'));
                }
        
        
        
                public function editarticle($article)
                {
                $hash=new Hashids();
                $tag = Tag::select('id', 'nama')->get();
                $article = Article::find($hash->decodeHex($article));
                return view('account.guide.article.edit', compact('article', 'tag','hash'));
        
        
                }
        
        
                public function updatearticle(Request $request, $id)
                {
                $hash = new Hashids();
                $request->validate([
                'judul' => 'required',
                'sampul' => 'mimes:jpg,jpeg,png',
                'konten' => 'required',
                'tag' => 'required',
                ]);
        
                $article = Article::findOrFail($hash->decodeHex($id));
        
                $data = [
                'judul' => $request->judul,
                'konten' => $request->konten,
                'slug' => Str::slug($request->judul, '-'),
                'created_by_id' => Auth::user()->id,
                'active' => $request->has('active') ? 1 : 0
                ];
        
                if ($request->hasFile('sampul')) {
                $request->validate([
                'sampul' => 'mimes:jpg,jpeg,png',
                ]);
        
                $sampul = time() . '-' . $request->sampul->getClientOriginalName();
                $request->sampul->move('upload/article', $sampul);
        
                File::delete('upload/article/' . $article->sampul);
                $data['sampul'] = $sampul;
                }
        
                $article->update($data);
                $article->tag()->sync($request->tag);
        
                Alert::success('Sukses', 'Data berhasil diubah');
                return redirect()->route('account.guide.article.index');
                }
        
        
                public function destroyarticle(Request $request,$article)
                {
                $hash=new Hashids();
                $article = Article::find($hash->decodeHex($article));
                File::delete('upload/article/' . $article->sampul);
                $article->delete();
        
        
                return back();
                }
        
                public function konfirmasi($id)
                {
                alert()->question('Peringatan !', 'Anda yakin akan menghapus data ?')
                ->showConfirmButton('<a href="/article/' . $id . '/delete" class="text-white" style="text-decoration: none"> Hapus</a>', '#3085d6')->toHtml()
                ->showCancelButton('Batal', '#aaa')->reverseButtons();
        
                return redirect()->route('account.guide.article.index');
                }
        
                public function delete($id)
                {
                $article = Article::select('sampul', 'id')->whereId($id)->where('created_by_id', Auth::user()->id)->firstOrFail();
                File::delete('upload/article/' . $article->sampul);
                $article->delete();
        
                Alert::success('Sukses', 'Data berhasil dihapus');
                return redirect()->route('account.guide.article.index');
                }


                public function GetBanerpromo()
                {
                    $hash=new Hashids();
                    $banerpromo = BanerPromo::all();
                    return view('account.guide.banerpromo.index', compact('banerpromo','hash'));
                }
            
            
                    public function createBanerpromo()
                        {
                             return view('account.guide.banerpromo.create');
                        }
            
            
                        public function storeBanerpromo(Request $request)
                        {
                            $request->validate([
                                'judul' => 'required',
                                'sampul' => 'required|mimes:jpg,jpeg,png',
                            ]);
                            if(!$request->active){
                                $request->merge([
                                    'active' => 0
                                ]);
                            }
                            $sampul = time() .'-' .$request->sampul->getClientOriginalName();
                            $request->sampul->move('upload/banerpromo', $sampul);
                    
                            BanerPromo::create([
                                'sampul' => $sampul,
                                'judul' => $request->judul,
                                'active' => $request->active,
                                'created_by_id' => Auth::user()->id
                            ]);
                    
                            Alert::success('Sukses', 'Data berhasil ditambahkan');
                            return redirect()->route('account.guide.banerpromo.index');
                        }
            
                        
             
                public function showBanerpromo($banerpromo)
                {
                                $hash=new Hashids();
                                $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                                return view('account.guide.banerpromo.show', compact('banerpromo','hash'));
                }
                /**
                 * Show the form for editing the specified resource.
                 *
                 * @param  int  $id
                 * @return \Illuminate\Http\Response
                 */
                public function editBanerpromo($banerpromo)
                {
                    $hash=new Hashids();
                    $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                    return view('account.guide.banerpromo.edit', compact( 'banerpromo','hash'))->with([
                        'banerpromo' => $banerpromo,
                        'hash' => $hash
                    ]);
                }
            
             
                public function updateBanerpromo(Request $request, $id)
                {
                    $hash = new Hashids();
                    
                    $request->validate([
                        'judul' => 'required',
                        'sampul' => 'mimes:jpg,jpeg,png',
                    ]);
                
                    $banerpromo = BanerPromo::findOrFail($hash->decodeHex($id));
                
                    $data = [
                        'judul' => $request->judul,
                        'created_by_id' => Auth::user()->id,
                        'active' => $request->has('active') ? 1 : 0
                    ];
                
                    if ($request->hasFile('sampul')) {
                        $request->validate([
                            'sampul' => 'mimes:jpg,jpeg,png',
                        ]);
                
                        $sampul = time() . '-' . $request->sampul->getClientOriginalName();
                        $request->sampul->move('upload/banerpromo', $sampul);
                
                        File::delete('upload/banerpromo/' . $banerpromo->sampul);
                        $data['sampul'] = $sampul;
                    }
                
                    $banerpromo->update($data);
                
                    Alert::success('Sukses', 'Data berhasil diubah');
                    return redirect()->route('account.guide.banerpromo.index');
                }
                
            
             
                
            
                    public function destroyBanerpromo(Request $request,$banerpromo)
                            {
                                $hash=new Hashids();
                                $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                                File::delete('upload/banerpromo/' . $banerpromo->sampul);
                                $banerpromo->delete();
                        
                        
                                return back();
                            }
            
                            public function massDestroyBanerpromo(MassDestroyBanerPromokRequest $request)
                {
                    BanerPromok::whereIn('id', request('ids'))->delete();
                    if (count($banerpromo->photos) > 0) {
                        foreach ($banerpromo->photos as $media) {
                            if (!in_array($media->file_name, $request->input('photos', []))) {
                                $media->delete();
                            }
                        }
                    }
                    return back();
            
                }
                public function getwisatawan()
    {
        $hash = new Hashids();
        $wisatawan = Wisatawan::all();
        return view('account.guide.getwisatawan', compact('wisatawan', 'hash'));
    }


}

