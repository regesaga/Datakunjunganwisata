<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\CategoryKuliner;
use App\Models\Pesankuliner;
use App\Models\PesananKulinerDetail;
use App\Models\BanerPromo;
use App\Models\Evencalender;
use App\Models\CategoryEvencalender;
use App\Models\KulinerProduk;
use App\Models\Wisatawan;
use App\Models\Kuliner;
use App\Models\Kecamatan;
use App\Models\Baner;
use App\Models\Fasilitas;
use App\Models\Company;
use App\Models\User;
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
class KulinerAuthorController extends Controller
{

    use MediaUploadingTrait;
    public function index()
    {   
        $company = null;
        $kuliner = null;
        $dashCount['kulinerproduk'] = null;

        if ($this->hasCompany()) {
            $company = auth()->user()->company;
        }

        if ($this->hasKuliner()) {
            $kuliner = auth()->user()->company->kuliner;
        $dashCount['kulinerproduk'] = KulinerProduk::where('kuliner_id', $kuliner->id)->count();

        }

        return view('account.kuliner.user-kuliner', compact('kuliner', 'company'))->with([
            'company' => $company,
            'dashCount' => $dashCount,
            'kuliner' => $kuliner
        ]);
    }

    
    
    public function changePasswordView()
    {
        $user = auth()->user(); // Get the authenticated user
        return view('account.kuliner.ganti-password');
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
                    return redirect()->route('account.kuliner.user-kuliner');
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
        return view('account.kuliner.company.create');
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
    return redirect()->route('account.kuliner.user-kuliner');
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
        return view('account.kuliner.company.edit', compact('company'))->with([
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
    
        return redirect()->route('account.kuliner.user-kuliner')->with('success', 'Data perusahaan berhasil diperbarui');
    }

   

    protected function hasCompany()
    {
        return auth()->user()->company !== null;
    }
    
    protected function hasKuliner()
    {
        return auth()->user()->company !== null && auth()->user()->company->kuliner !== null;
    }
    
    public function createKuliner()
    {
        $company = auth()->user()->company;
        $categories = CategoryKuliner::all();
        $kecamatan = Kecamatan::all();
    
        return view('account.kuliner.kuliner.create', compact('company', 'categories', 'kecamatan'));
    }



    public function storeKuliner(Request $request)
{
    $company_id = Auth::user()->company->id;
    $data = $request->all();

        try {

            \DB::beginTransaction();

            $validatedData['company_id'] = $company_id;
            $kuliner = new Kuliner($request->all());
            $kuliner->company_id = $company_id;
            $kuliner->save();
            

            foreach ($request->input('photos', []) as $file) {
                $kuliner->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     

          
            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.kuliner.user-kuliner')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            

            
     


    public function editkuliner()
    {
        $company_id = auth()->user()->company->id;
        $kuliner = Kuliner::where('company_id', $company_id)->first();
        $categories = CategoryKuliner::all();
        $kecamatan = Kecamatan::all();
    
        return view('account.kuliner.kuliner.edit', compact('kuliner', 'categories', 'kecamatan'));
    }
    
  
    public function kulinerupdate(Request $request, $kuliner)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $kuliner = Kuliner::find($kuliner);
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $kuliner->update($request->all());

        if (count($kuliner->photos) > 0) {
            foreach ($kuliner->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $kuliner->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $kuliner->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           
        
        

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.kuliner.user-kuliner')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
   


            // Kuliner Produk


        public function getKulinerproduk()
        {   
            $hash=new Hashids();

            $company = auth()->user()->company;
              // Check if the company has a related kuliner
            if (!$company || !$company->kuliner || !$company->kuliner->id) {
                // Redirect back with an error message if kuliner_id is not available
                return redirect()->back()->with('maaf', 'Anda belum Mengisi Detail Wisata.');
            }

            $kuliner_id = auth()->user()->company->kuliner->id;
            $kulinerproduks = KulinerProduk::where('kuliner_id', $kuliner_id)->get();

            return view('account.kuliner.kulinerproduk.index', compact('kulinerproduks','hash'));
        }

            

    public function storeKulinerproduk(Request $request)
{
    $kuliner_id = Auth::user()->company->kuliner->id;
    $data = $request->all();

        try {

            \DB::beginTransaction();


            $validatedData['kuliner_id'] = $kuliner_id;
            $kulinerproduk = new KulinerProduk($request->all());
            $kulinerproduk->kuliner_id = $kuliner_id;
            $kulinerproduk->save();
            
            foreach ($request->input('photos', []) as $file) {
                $kulinerproduk->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.kuliner.kulinerproduk.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            


    public function createKulinerproduk()
    {
        
        $kuliner = Kuliner::all();
        
        return view('account.kuliner.kulinerproduk.create',  compact('kuliner'));
    }

    public function showkulinerproduk($kulinerproduk)
    {
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        return view('account.kuliner.kulinerproduk.show', compact('kulinerproduk','hash'));
    }


    public function showdetailkulinerproduk($id)
    {
        $kulinerproduk = KulinerProduk::find($id);
        return view('account.detailkulinerproduk', compact('kulinerproduk'));
    }

   
    public function massDestroy(MassDestroyKulinerProdukRequest $request)
    {
        KulinerProduk::whereIn('id', request('ids'))->delete();
        if (count($kulinerproduk->photos) > 0) {
            foreach ($kulinerproduk->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }

    public function destroy(Request $request,$kulinerproduk)
    {
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        $kulinerproduk->delete();
        if (count($kulinerproduk->photos) > 0) {
            foreach ($kulinerproduk->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editkulinerproduk($kulinerproduk)
    {
        $kuliner = Kuliner::all();
        
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        return view('account.kuliner.kulinerproduk.edit', compact( 'kulinerproduk','kuliner'))->with([
            'kulinerproduk' => $kulinerproduk,
            'kuliner' => $kuliner,
            'hash' => $hash
        ]);
    }
  
    public function kulinerprodukupdate(Request $request, $kulinerproduk)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $kulinerproduk->update($request->all());

        if (count($kulinerproduk->photos) > 0) {
            foreach ($kulinerproduk->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $kulinerproduk->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $kulinerproduk->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.kuliner.kulinerproduk.index')->with('status', 'Data Berhasil Di Input');
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
                return view('account.kuliner.tag.index', compact('tag','hash'));
            }
        
        
        
            public function createTag()
            {
            return view('account.kuliner.tag.create');
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
            return redirect()->route('account.kuliner.tag.index');
        }
        
        
                public function editTag($tag)
                {
                $hash=new Hashids();
                $tag = Tag::find($hash->decodeHex($tag));
                return view('account.kuliner.tag.edit', compact( 'tag','hash'))->with([
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
                return redirect()->route('account.kuliner.tag.index');
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
                return view('account.kuliner.article.index', compact('article','hash','tag'))->with([
                'hash' => $hash,
                'tag' => $tag
                ]);
                }
        
                public function createarticle()
                {
                $hash=new Hashids();
                $tag = Tag::all();
                return view('account.kuliner.article.create', compact( 'tag', 'hash'))->with([
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
                return redirect()->route('account.kuliner.article.index');
                }
        
        
        
                public function showarticle($article)
                {
                    $hash=new Hashids();
                    $article = Article::find($hash->decodeHex($article));
                    return view('account.kuliner.article.show', compact('article','hash'));
                }
        
        
        
                public function editarticle($article)
                {
                $hash=new Hashids();
                $tag = Tag::select('id', 'nama')->get();
                $article = Article::find($hash->decodeHex($article));
                return view('account.kuliner.article.edit', compact('article', 'tag','hash'));
        
        
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
                return redirect()->route('account.kuliner.article.index');
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
        
                return redirect()->route('account.kuliner.article.index');
                }
        
                public function delete($id)
                {
                $article = Article::select('sampul', 'id')->whereId($id)->where('created_by_id', Auth::user()->id)->firstOrFail();
                File::delete('upload/article/' . $article->sampul);
                $article->delete();
        
                Alert::success('Sukses', 'Data berhasil dihapus');
                return redirect()->route('account.kuliner.article.index');
                }

                public function GetBanerpromo()
    {
        $hash=new Hashids();
        $banerpromo = BanerPromo::all();
        return view('account.kuliner.banerpromo.index', compact('banerpromo','hash'));
    }


        public function createBanerpromo()
            {
                 return view('account.kuliner.banerpromo.create');
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
                return redirect()->route('account.kuliner.banerpromo.index');
            }

            
 
    public function showBanerpromo($banerpromo)
    {
                    $hash=new Hashids();
                    $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                    return view('account.kuliner.banerpromo.show', compact('banerpromo','hash'));
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
        return view('account.kuliner.banerpromo.edit', compact( 'banerpromo','hash'))->with([
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
        return redirect()->route('account.kuliner.banerpromo.index');
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
        return view('account.kuliner.getwisatawan', compact('wisatawan', 'hash'));
    }


    public function getAllEven()
    {
        $hash = new Hashids();
        $company = null;
        $kuliner = null;
        $dashCount['kulinerproduk'] = null;
    
        if ($this->hasCompany()) {
            $company = auth()->user()->company;
        }
    
        if ($this->hasKuliner()) {
            $kuliner = auth()->user()->company->kuliner;
            $dashCount['kulinerproduk'] = KulinerProduk::where('kuliner_id', $kuliner->id)->count();
        }
        $id = Auth::id();
        $even = Evencalender::where('created_by_id', $id)->get();
        return view('account.kuliner.even.index', compact('even','kuliner', 'company','hash'))->with([
            'company' => $company,
            'dashCount' => $dashCount,
            'kuliner' => $kuliner
        ]);
    }

    public function storeEven(Request $request)
    {
        try {
            $even = Evencalender::create($request->all());
    
            foreach ($request->input('photos', []) as $file) {
                $even->addMedia(storage_path('tmp/uploads/' . $file))
                    ->withCustomProperties([
                        'width' => 6250,
                        'height' => 4419
                    ])
                    ->toMediaCollection('photos');
            }
    
            Log::info('Even created successfully', ['even_id' => $even->id]);
    
            return redirect()->route('account.kuliner.even.index');
        } catch (\Exception $e) {
            Log::error('Error creating even', ['error' => $e->getMessage()]);
            return back()->withError('Error creating even')->withInput();
        }
    }



    public function createEven()
    {

        return view('account.kuliner.even.create');
    }

    public function showeven($even)
    {
        $hash = new Hashids();
        $even = Evencalender::find($hash->decodeHex($even));
        return view('account.kuliner.even.show', compact('even', 'hash'));
    }



    public function massDestroyEven(MassDestroyEvencalenderRequest $request)
    {
        Evencalender::whereIn('id', request('ids'))->delete();
        if (count($even->photos) > 0) {
            foreach ($even->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();
    }

    public function destroyEven(Request $request, $even)
    {
        $hash = new Hashids();
        $even = Evencalender::find($hash->decodeHex($even));
        $even->delete();
        if (count($even->photos) > 0) {
            foreach ($even->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editeven($even)
    {
        $hash = new Hashids();
        $even = Evencalender::find($hash->decodeHex($even));
        return view('account.kuliner.even.edit', compact('even'))->with([
            'even' => $even,
            'hash' => $hash
        ]);
    }

    public function evenupdate(Request $request, $even)
    {
        try {
            if (!$request->active) {
                $request->merge([
                    'active' => 0
                ]);
            }
    
            $hash = new Hashids();
            $decodedId = $hash->decodeHex($even);
            $even = Evencalender::find($decodedId);
            $even->update($request->all());
    
            if (count($even->photos) > 0) {
                foreach ($even->photos as $media) {
                    if (!in_array($media->file_name, $request->input('photos', []))) {
                        $media->delete();
                    }
                }
            }
    
            $media = $even->photos->pluck('file_name')->toArray();
    
            foreach ($request->input('photos', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $even->addMedia(storage_path('tmp/uploads/' . $file))
                        ->withCustomProperties([
                            'width' => 4419,
                            'height' => 6250
                        ])
                        ->toMediaCollection('photos');
                }
            }
    
            Log::info('Evencalender updated successfully', ['even_id' => $decodedId]);
    
            return redirect()->route('account.kuliner.even.index');
        } catch (\Exception $e) {
            Log::error('Error updating even', ['error' => $e->getMessage()]);
            return back()->withError('Error updating even')->withInput();
        }
    }


    public function getAllfasilitas()
    {
       
        $company = null;
        $kuliner = null;
        $dashCount['kulinerproduk'] = null;
        $hash=new Hashids();
        $fasilitas = Fasilitas::all();

        if ($this->hasCompany()) {
            $company = auth()->user()->company;
        }

        if ($this->hasKuliner()) {
            $kuliner = auth()->user()->company->kuliner;
        $dashCount['kulinerproduk'] = KulinerProduk::where('kuliner_id', $kuliner->id)->count();

        }

        return view('account.kuliner.fasilitas.index', compact('kuliner', 'company', 'fasilitas','hash'))->with([
            'company' => $company,
            'dashCount' => $dashCount,
            'kuliner' => $kuliner
        ]);

    }



    public function storefasilitas(Request $request)
    {
        $request->validate([
            'fasilitas_name' => 'required|min:5'
        ]);
        Fasilitas::create([
            'fasilitas_name' => $request->fasilitas_name
        ]);
        Alert::toast('Fasilitas dibuat!', 'success');
        return redirect()->route('account.kuliner.fasilitas.index');
    }


    public function createfasilitas()
    {

        return view('account.kuliner.fasilitas.create');
    }

    public function editfasilitas($fasilitas)
    {
        $hash=new Hashids();
        $fasilitas = Fasilitas::find($hash->decodeHex($fasilitas));
        return view('account.kuliner.fasilitas.edit', compact('fasilitas','hash'))->with([
            'fasilitas' => $fasilitas,
            'hash' => $hash
        ]);
    }

    public function fasilitasupdate(Request $request, $fasilitas)  
    {
        $hash=new Hashids();
        $fasilitas= Fasilitas::find($hash->decodeHex($fasilitas));
        $newFasilitas = $fasilitas->update($request->all());


        Alert::toast('Fasilitas Updated!', 'success');
        return redirect()->route('account.kuliner.fasilitas.index');
    }

    public function destroyfasilitas($id)
    {
        $fasilitas = Fasilitas::find($id);
        $fasilitas->delete();
        Alert::toast('Fasilitas Delete!', 'success');
        return redirect()->route('account.kuliner.fasilitas.index');
    }


    public function pesankuliner()
{
    // Create a new Hashids instance
    $hash = new Hashids();

    // Retrieve the authenticated user's company
    $company = auth()->user()->company;

    // Check if the company has a related kuliner
    if (!$company || !$company->kuliner || !$company->kuliner->id) {
        // Redirect back with an error message if kuliner_id is not available
        return redirect()->back()->with('maaf', 'Anda belum Mengisi Detail Kuliner.');
    }

    // Retrieve the kuliner ID
    $kulinerId = $company->kuliner->id;

    // Fetch all Pesankuliner records for the given kuliner ID
    $pesankuliner = Pesankuliner::where('kuliner_id', $kulinerId)->get();

    // Return the view with the pesankuliner and hash variables
    return view('account.kuliner.pesankuliner', compact('pesankuliner', 'hash'));
}


public function detailkuliner($id)
{
    $hash = new Hashids();
    $decodedId = $hash->decodeHex($id);
    $detailkuliner = PesananKulinerDetail::where('pesankuliner_id', $decodedId)->get();

    if ($detailkuliner->isEmpty()) {
        return redirect()->back()->with('error', 'Data detail kuliner tidak ditemukan.');
    }

    return view('account.kuliner.detailpesanan', compact('detailkuliner', 'hash'));
}



public function cekpesanan()
{
    $hash = new Hashids();
    $company = auth()->user()->company;

    // Check if the company has a related kuliner
    if (!$company || !$company->kuliner || !$company->kuliner->id) {
        // Redirect back with an error message if kuliner_id is not available
        return redirect()->back()->with('maaf', 'Anda belum Mengisi Detail Kuliner.');
    }

    // Retrieve the kuliner ID
    $kulinerId = $company->kuliner->id;
    $pesankuliner = Pesankuliner::where('kuliner_id', $kulinerId)->where('kodepesanan', request()->kodepesanan)->get();
    $pesanankuliner = Pesankuliner::where('kuliner_id', $kulinerId)->get();
    
    if (isset(request()->kodepesanan) && $pesankuliner->count() > 0) {
        return redirect('kuliner/pesanan/' . request()->kodepesanan);
    } else if (isset(request()->kodepesanan) && $pesankuliner->count() == 0) {
        return redirect('kuliner/cekpesanan ')->with('error', 'Kode tidak ditemukan !');
    } else {
        return view('account.kuliner.pesankuliner', compact('pesanankuliner', 'hash'));
    }
}
public function showpesanan(Pesankuliner $pesankuliner)
{
    $detailkuliner = PesananKulinerDetail::where('pesankuliner_id', $pesankuliner->id)->get();
    return view('account.kuliner.showpesanan', [
        'pesankuliner' => $pesankuliner,
        'detailkuliner' => $detailkuliner,
    ]);
}



public function checkin_pesanan(Pesankuliner $pesankuliner)
{
Pesankuliner::where('kodepesanan', $pesankuliner->kodepesanan)->update(['statuspesanan' => '11', 'payment_status' => '11']);
return redirect('kuliner/pesanan/' . $pesankuliner->kodepesanan)->with('success', 'Berhasil Checkin!');
}


 
}
