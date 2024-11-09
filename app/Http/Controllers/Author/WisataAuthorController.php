<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Wisata;
use App\Models\Evencalender;
use App\Models\CategoryEvencalender;
use App\Models\Pesantiket;
use App\Models\Reserv;
use App\Models\Reservation;
use App\Models\PesananTiketDetail;
use App\Models\Pesankuliner;
use App\Models\PesananKulinerDetail;
use App\Models\Akomodasi;
use App\Models\CategoryAkomodasi;
use App\Models\CategoryRooms;
use App\Models\Rooms;
use App\Models\PaketWisata;
use App\Models\Wisatawan;
use App\Models\BanerPromo;
use App\Models\Htpaketwisata;
use App\Models\Company;
use App\Models\User;
use App\Models\CategoryWisata;
use App\Models\Fasilitas;
use App\Models\Kecamatan;
use App\Models\HargaTiket;
use App\Models\CategoryKuliner;
use App\Models\KulinerProduk;
use App\Models\Kuliner;
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
class WisataAuthorController extends Controller
{
    use MediaUploadingTrait;


        
    public function index()
{   
    $company = null;
    $wisata = null;
    $hargatiket = null;

    if ($this->hasCompany()) {
        $company = auth()->user()->company;
    }

    if ($this->hasWisata()) {
        $wisata = auth()->user()->company->wisata;
        $hargatiket = $wisata->hargatiket;
    }

  

    return view('account.wisata.user-wisata', compact('wisata', 'company', 'hargatiket'))->with([
        'company' => $company,
        'wisata' => $wisata,
        'hargatiket' => $hargatiket,
    ]);
}

public function wisatakuliner()
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

    return view('account.wisata.user-wisatakuliner', compact('kuliner', 'company'))->with([
        'company' => $company,
        'dashCount' => $dashCount,
        'kuliner' => $kuliner
    ]);
}

public function wisataakomodasi()
{   
    $company = null;
    $akomodasi = null;
    $dashCount['room'] = null;
    if ($this->hasCompany()) {
        $company = auth()->user()->company;
    }

    if ($this->hasAkomodasi()) {
        $akomodasi = auth()->user()->company->akomodasi;
        $dashCount['room'] = Rooms::where('akomodasi_id', $akomodasi->id)->count();
    }

  

    return view('account.wisata.user-wisataakomodasi', compact('akomodasi', 'company'))->with([
        'company' => $company,
        'dashCount' => $dashCount,
        'akomodasi' => $akomodasi
    ]);
}

public function wisataguide()
{   
    

    
    $hash=new Hashids();
        $id = Auth::id();
        $guide = PaketWisata::where('created_by_id', $id)->get();
        $htpaketwisata = Htpaketwisata::all();

    return view('account.wisata.guide.index', compact('guide', 'hash', 'htpaketwisata'))->with([
        'hash' => $hash,
        'guide' => $guide,
        'htpaketwisata' => $htpaketwisata
    ]);
}

   
    

    public function changePasswordView()
    {
        return view('account.wisata.ganti-password');
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
                    return redirect()->route('account.wisata.user-wisata');
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
        return view('account.wisata.company.create');
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
    return redirect()->route('account.wisata.user-wisata');
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
        return view('account.wisata.company.edit', compact('company'))->with([
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
    
        return redirect()->route('account.wisata.user-wisata')->with('success', 'Data perusahaan berhasil diperbarui');
    }

    public function destroy()
    {
        Storage::delete('public/companies/logos/' . basename(auth()->user()->company->logo));
        if (auth()->user()->company->delete()) {
            return redirect()->route('account.wisata.user-wisata');
        }
        return redirect()->route('account.wisata.user-wisata');
    }

    protected function hasCompany()
    {
        return auth()->user()->company !== null;
    }
    
    protected function hasWisata()
    {
        return auth()->user()->company !== null && auth()->user()->company->wisata !== null;
    }
    

    public function createWisata()
    {
        $company = auth()->user()->company;
        $categories = CategoryWisata::all();
        $fasilitas = Fasilitas::pluck('fasilitas_name', 'id');
        $kecamatan = Kecamatan::all();
    
        return view('account.wisata.wisata.create', compact('company', 'categories', 'fasilitas', 'kecamatan'));
    }



    public function storeWisata(Request $request)
{
    $company_id = Auth::user()->company->id;
    $data = $request->all();

        try {

            \DB::beginTransaction();

            $validatedData['company_id'] = $company_id;
            $wisata = new Wisata($request->all());
            $wisata->company_id = $company_id;
            $wisata->save();
            $wisata->fasilitas()->sync($request->input('fasilitas', []));

            foreach ($request->input('photos', []) as $file) {
                $wisata->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     

            if ($request->kategori) {
                foreach ($data['kategori'] as $item => $value) {
                    $data2 = array(
                        'wisata_id' => $wisata->id,
                        'kategori' => $data['kategori'][$item],
                        'harga' => $data['harga'][$item],
                    );
                    HargaTiket::create($data2);
                }
            }

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.wisata.user-wisata')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            

            
    public function showwisata($wisata)
    {
        $hash=new Hashids();
        $wisata = Wisata::find($hash->decodeHex($wisata));
        $hargatiket = $wisata->hargatiket;
        $wisata->load('fasilitas', 'created_by');
        return view('account.wisata.user-wisata', compact('wisata','hash','hargatiket'));
    }
    

 


    public function editwisata()
    {
        $company_id = auth()->user()->company->id;
        $wisata = Wisata::where('company_id', $company_id)->first();
        $categories = CategoryWisata::all();
        $kecamatan = Kecamatan::all();
        $fasilitas = Fasilitas::pluck('fasilitas_name', 'id');
    
        return view('account.wisata.wisata.edit', compact('wisata', 'fasilitas', 'categories', 'kecamatan'));
    }
    
  
    public function wisataupdate(Request $request, $wisata)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $wisata = Wisata::with('hargatiket')->find($wisata);
        HargaTiket::where('wisata_id', $wisata->id)->delete();
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $wisata->update($request->all());
            $wisata->fasilitas()->sync($request->input('fasilitas', []));

        if (count($wisata->photos) > 0) {
            foreach ($wisata->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $wisata->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $wisata->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           
        if ($request->kategori && isset($data['kategori'])) {
            foreach ($data['kategori'] as $item => $value) {
                $data2 = array(
                    'wisata_id' => $wisata->id,
                    'kategori' => $data['kategori'][$item],
                    'harga' => $data['harga'][$item],
                );
                HargaTiket::create($data2);
            }
        }
        

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.wisata.user-wisata')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
   

            public function getAllfasilitas()
    {
        $hash=new Hashids();
        $fasilitas = Fasilitas::all();


        return view('account.wisata.fasilitas.index', compact('fasilitas','hash'));
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
        return redirect()->route('account.wisata.fasilitas.index');
    }


    public function createfasilitas()
    {

        return view('account.wisata.fasilitas.create');
    }

    public function editfasilitas($fasilitas)
    {
        $hash=new Hashids();
        $fasilitas = Fasilitas::find($hash->decodeHex($fasilitas));
        return view('account.wisata.fasilitas.edit', compact('fasilitas','hash'))->with([
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
        return redirect()->route('account.wisata.fasilitas.index');
    }

    public function destroyfasilitas($id)
    {
        $fasilitas = Fasilitas::find($id);
        $fasilitas->delete();
        Alert::toast('Fasilitas Delete!', 'success');
        return redirect()->route('account.wisata.fasilitas.index');
    }
    
    
    protected function hasAkomodasi()
    {
        return auth()->user()->company !== null && auth()->user()->company->akomodasi !== null;
    }
    

    public function createAkomodasi()
    {
        $company = auth()->user()->company;
        $categories = CategoryAkomodasi::all();
        $fasilitas = Fasilitas::pluck('fasilitas_name', 'id');
        $kecamatan = Kecamatan::all();
    
        return view('account.wisata.akomodasi.create', compact('company', 'categories', 'fasilitas', 'kecamatan'));
    }



    public function storeAkomodasi(Request $request)
{
    $company_id = Auth::user()->company->id;
    $data = $request->all();

        try {

            \DB::beginTransaction();

            $validatedData['company_id'] = $company_id;
            $akomodasi = new Akomodasi($request->all());
            $akomodasi->company_id = $company_id;
            $akomodasi->save();
            $akomodasi->fasilitas()->sync($request->input('fasilitas', []));

            foreach ($request->input('photos', []) as $file) {
                $akomodasi->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
     


            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.wisata.user-wisataakomodasi')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            

            


    public function editakomodasi()
    {
        $company_id = auth()->user()->company->id;
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
        $categories = CategoryAkomodasi::all();
        $kecamatan = Kecamatan::all();
        $fasilitas = Fasilitas::pluck('fasilitas_name', 'id');
    
        return view('account.wisata.akomodasi.edit', compact('akomodasi', 'fasilitas', 'categories', 'kecamatan'));
    }
    
  
    public function akomodasiupdate(Request $request, $akomodasi)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $akomodasi = Akomodasi::find($akomodasi);
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $akomodasi->update($request->all());
            $akomodasi->fasilitas()->sync($request->input('fasilitas', []));

        if (count($akomodasi->photos) > 0) {
            foreach ($akomodasi->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $akomodasi->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $akomodasi->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           
        
            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.wisata.user-wisataakomodasi')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }


            // Rooom Add 
            // Rooom Add 
            // Rooom Add 
            // Rooom Add 

            public function getRoom()
    {
        $hash=new Hashids();

        $akomodasi_id = auth()->user()->company->akomodasi->id;
        $rooms = Rooms::where('akomodasi_id', $akomodasi_id)->get();
        $categories = CategoryRooms::all();
        $fasilitas = Fasilitas::all();
        
        return view('account.wisata.room.index', compact('rooms','hash', 'categories','fasilitas'));
    }

    public function storeRoom(Request $request)
    {
        $akomodasi_id = Auth::user()->company->akomodasi->id;
    
        try {
            \DB::beginTransaction();
    
            $room = new Rooms($request->all());
            $room->akomodasi_id = $akomodasi_id;
            $room->save();
    
            $room->fasilitas()->sync($request->input('fasilitas', []));
    
            foreach ($request->input('photos', []) as $file) {
                $room->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
    
            \DB::commit();
            Log::info('Data Berhasil Di Input');
    
            return redirect()->route('account.wisata.room.index')->with('status', 'Data Berhasil Di Input');
        } catch (\Throwable $th) {
            \DB::rollback();
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
        }
    }
    



    public function createRoom()
    {
        
        $akomodasi = Akomodasi::all();
        $categories = CategoryRooms::all();
        $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
        
        return view('account.wisata.room.create',  compact('akomodasi', 'categories','fasilitas'));
    }

    public function showroom($room)
    {
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $room->load('fasilitas', 'created_by');
        return view('account.wisata.room.show', compact('room','hash'));
    }


    public function showdetailroom($id)
    {
        $room = Rooms::find($id);
        $room->load('fasilitas', 'created_by');
        return view('account.wisata.detailroom', compact('room'));
    }

   
    public function massDestroy(MassDestroyRoomsRequest $request)
    {
        Rooms::whereIn('id', request('ids'))->delete();
        if (count($room->photos) > 0) {
            foreach ($room->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }

    public function destroyRoom(Request $request,$room)
    {
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $room->delete();
        if (count($room->photos) > 0) {
            foreach ($room->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        return back();
    }

    public function editroom($room)
    {
        $akomodasi = Akomodasi::all();
        
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $categories = CategoryRooms::all();
        $fasilitas = Fasilitas::all()->pluck('fasilitas_name', 'id');
        return view('account.wisata.room.edit', compact( 'room','akomodasi','fasilitas', 'categories'))->with([
            'room' => $room,
            'akomodasi' => $akomodasi,
            'categories' => $categories,
            'fasilitas' => $fasilitas,
            'hash' => $hash
        ]);
    }
  
    public function roomupdate(Request $request, $room)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        
        $data = $request->all();
        try {

            \DB::beginTransaction();
            $room->update($request->all());
            $room->fasilitas()->sync($request->input('fasilitas', []));

        if (count($room->photos) > 0) {
            foreach ($room->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $room->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $room->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

           

            DB::commit();
            Log::info('Data Berhasil Di Input');
            
            return redirect()->route('account.wisata.room.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
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
    
        return view('account.wisata.kuliner.create', compact('company', 'categories', 'kecamatan'));
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
            
            return redirect()->route('account.wisata.user-wisatakuliner')->with('status', 'Data Berhasil Di Input');
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
    
        return view('account.wisata.kuliner.edit', compact('kuliner', 'categories', 'kecamatan'));
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
            
            return redirect()->route('account.wisata.user-wisatakuliner')->with('status', 'Data Berhasil Di Input');
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

            $kuliner_id = auth()->user()->company->kuliner->id;
            $kuliner = auth()->user()->company->kuliner;
            $kulinerproduks = KulinerProduk::where('kuliner_id', $kuliner_id)->get();
            $dashCount['kulinerproduk'] = KulinerProduk::where('kuliner_id', $kuliner->id)->count();


            return view('account.wisata.kulinerproduk.index', compact('kulinerproduks','hash','dashCount','kuliner'));
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
            
            return redirect()->route('account.wisata.kulinerproduk.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }
            


    public function createKulinerproduk()
    {
        
        $kuliner = Kuliner::all();
        
        return view('account.wisata.kulinerproduk.create',  compact('kuliner'));
    }

    public function showkulinerproduk($kulinerproduk)
    {
        $hash=new Hashids();
        $kulinerproduk = KulinerProduk::find($hash->decodeHex($kulinerproduk));
        return view('account.wisata.kulinerproduk.show', compact('kulinerproduk','hash'));
    }


    public function showdetailkulinerproduk($id)
    {
        $kulinerproduk = KulinerProduk::find($id);
        return view('account.detailkulinerproduk', compact('kulinerproduk'));
    }

   
   

    public function destroykulinerproduk(Request $request,$kulinerproduk)
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
        return view('account.wisata.kulinerproduk.edit', compact( 'kulinerproduk','kuliner'))->with([
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
            
            return redirect()->route('account.wisata.kulinerproduk.index')->with('status', 'Data Berhasil Di Input');
            } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
            }
            }


            protected function hasGuide()
            {
                return auth()->user()->company !== null && auth()->user()->company->paketwisata !== null;
            }
            
        
            public function createGuide()
            {
                $company = auth()->user()->company;
            
                return view('account.wisata.guide.create', compact('company'));
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
                    
                    return redirect()->route('account.wisata.guide.index')->with('status', 'Data Berhasil Di Input');
                    } catch (\Throwable $th) {
                    DB::rollback();
                    
                    Log::error('Gagal menyimpan data ke database: ' . $th->getMessage());
                    
                    return redirect()->back()->with('error', 'Gagal menyimpan data ke database: ' . $th->getMessage());
                    }
                    }
                    
        
                    
          
            public function editguide()
            {
                $company_id = auth()->user()->company->id;
                $guide = PaketWisata::where('company_id', $company_id)->first();
            
                return view('account.wisata.guide.edit', compact('guide'));
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
                    
                    return redirect()->route('account.wisata.guide.index')->with('status', 'Data Berhasil Di Input');
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

                    public function massDestroyGuide(MassDestroyPaketWisataRequest $request)
                    {
                        PaketWisata::whereIn('id', request('ids'))->delete();
                        if (count($guide->photos) > 0) {
                            foreach ($guide->photos as $media) {
                                if (!in_array($media->file_name, $request->input('photos', []))) {
                                    $media->delete();
                                }
                            }
                        }
                        return back();
                
                    }

                    public function showguide($guide)
                    {
                        $hash=new Hashids();
                        $guide = PaketWisata::find($hash->decodeHex($guide));
                        $htpaketwisata = $guide->htpaketwisata;
                        return view('account.wisata.guide.show', compact('guide','hash','htpaketwisata'));
                    }




                    public function getAllEven()
                    {
                        $hash = new Hashids();
                        $id = Auth::id();
                        $even = Evencalender::where('created_by_id', $id)->get();
                        return view('account.wisata.even.index', compact('even', 'hash'));
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
                    
                            return redirect()->route('account.wisata.even.index');
                        } catch (\Exception $e) {
                            Log::error('Error creating even', ['error' => $e->getMessage()]);
                            return back()->withError('Error creating even')->withInput();
                        }
                    }
                
                
                
                    public function createEven()
                    {
                
                        return view('account.wisata.even.create');
                    }
                
                    public function showeven($even)
                    {
                        $hash = new Hashids();
                        $even = Evencalender::find($hash->decodeHex($even));
                        return view('account.wisata.even.show', compact('even', 'hash'));
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
                        return view('account.wisata.even.edit', compact('even'))->with([
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
                    
                            return redirect()->route('account.wisata.even.index');
                        } catch (\Exception $e) {
                            Log::error('Error updating even', ['error' => $e->getMessage()]);
                            return back()->withError('Error updating even')->withInput();
                        }
                    }
     

    public function GetBanerpromo()
    {
        $hash=new Hashids();
        $id = Auth::id();
        $banerpromo = BanerPromo::where('created_by_id', $id)->get();
        return view('account.wisata.banerpromo.index', compact('banerpromo','hash'));
    }


        public function createBanerpromo()
            {
                 return view('account.wisata.banerpromo.create');
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
                return redirect()->route('account.wisata.banerpromo.index');
            }

            
 
    public function showBanerpromo($banerpromo)
    {
                    $hash=new Hashids();
                    $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                    return view('account.wisata.banerpromo.show', compact('banerpromo','hash'));
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
        return view('account.wisata.banerpromo.edit', compact( 'banerpromo','hash'))->with([
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
        return redirect()->route('account.wisata.banerpromo.index');
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
        return view('account.wisata.getwisatawan', compact('wisatawan', 'hash'));
    }

    
    
    public function detailtiket($id)
    {
        $hash = new Hashids();
        $decodedId = $hash->decodeHex($id);
        $detailtiket = PesananTiketDetail::where('pesantiket_id', $decodedId)->get();
        
        if ($detailtiket->isEmpty()) {
            return redirect()->back()->with('error', 'Data detail tiket tidak ditemukan.');
        }
    
        return view('account.wisata.detailtiket', compact('detailtiket', 'hash'));
    }



    public function cek()
    {
        $hash = new Hashids();
        $company = auth()->user()->company;
    
        // Check if the company has a related wisata
        if (!$company || !$company->wisata || !$company->wisata->id) {
            // Redirect back with an error message if wisata_id is not available
            return redirect()->back()->with('maaf', 'Anda belum Mengisi Detail Wisata.');
        }
    
        // Retrieve the wisata ID
        $wisataId = $company->wisata->id;
        $pesantiket = Pesantiket::where('wisata_id', $wisataId)->where('kodetiket', request()->kodetiket)->get();
        $pesanantiket = Pesantiket::where('wisata_id', $wisataId)->get();
        if (isset(request()->kodetiket) && $pesantiket->count() > 0) {
            return redirect('wisata/tiket/' . request()->kodetiket);
        } else if (isset(request()->kodetiket) && $pesantiket->count() == 0) {
            return redirect('wisata/cek')->with('error', 'Kode tidak ditemukan !');
        } else {
            return view('account.wisata.tiketwisata', compact('pesanantiket', 'hash'));
        }
    }
    public function show(Pesantiket $pesantiket)
    {
        $detailtiket = PesananTiketDetail::where('pesantiket_id', $pesantiket->id)->get();
        return view('account.wisata.show', [
            'pesantiket' => $pesantiket,
            'detailtiket' => $detailtiket,
        ]);
    }

   


    public function checkin_checkin(Pesantiket $pesantiket)
{
    Pesantiket::where('kodetiket', $pesantiket->kodetiket)->update(['statuspemakaian' => '11', 'payment_status' => '11']);
    return redirect('wisata/tiket/' . $pesantiket->kodetiket)->with('success', 'Berhasil Checkin!');
}


public function checkin_tunai(Pesantiket $pesantiket)
{
    Pesantiket::where('kodetiket', $pesantiket->kodetiket)->update([
        'statuspemakaian' => '11', 
        'payment_status' => '11', 
        'metodepembayaran' => 'Tunai'
    ]);
    return redirect('wisata/tiket/' . $pesantiket->kodetiket)->with('success', 'Berhasil Checkin dengan tunai!');
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
    return view('account.wisata.pesankuliner', compact('pesankuliner', 'hash'));
}


public function detailkuliner($id)
{
    $hash = new Hashids();
    $decodedId = $hash->decodeHex($id);
    $detailkuliner = PesananKulinerDetail::where('pesankuliner_id', $decodedId)->get();

    if ($detailkuliner->isEmpty()) {
        return redirect()->back()->with('error', 'Data detail kuliner tidak ditemukan.');
    }

    return view('account.wisata.detailpesanan', compact('detailkuliner', 'hash'));
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
        return redirect('wisata/pesanan/' . request()->kodepesanan);
    } else if (isset(request()->kodepesanan) && $pesankuliner->count() == 0) {
        return redirect('wisata/cekpesanan ')->with('error', 'Kode tidak ditemukan !');
    } else {
        return view('account.wisata.pesankuliner', compact('pesanankuliner', 'hash'));
    }
}
public function showpesanan(Pesankuliner $pesankuliner)
{
    $detailkuliner = PesananKulinerDetail::where('pesankuliner_id', $pesankuliner->id)->get();
    return view('account.wisata.showpesanan', [
        'pesankuliner' => $pesankuliner,
        'detailkuliner' => $detailkuliner,
    ]);
}



public function checkin_pesanan(Pesankuliner $pesankuliner)
{
Pesankuliner::where('kodepesanan', $pesankuliner->kodepesanan)->update(['statuspesanan' => '11', 'payment_status' => '11']);
return redirect('wisata/pesanan/' . $pesankuliner->kodepesanan)->with('success', 'Berhasil Checkin!');
}




public function reserv()
{
    // Create a new Hashids instance
    $hash = new Hashids();

    // Retrieve the authenticated user's company
    $company = auth()->user()->company;

    // Check if the company has a related akomodasi
    if (!$company || !$company->akomodasi || !$company->akomodasi->id) {
        // Redirect back with an error message if akomodasi_id is not available
        return redirect()->back()->with('maaf', 'Anda belum Mengisi Detail Kuliner.');
    }

    // Retrieve the akomodasi ID
    $akomodasiId = $company->akomodasi->id;

    // Fetch all Reserv records for the given akomodasi ID
    $reserv = Reserv::where('akomodasi_id', $akomodasiId)->get();

    // Return the view with the reserv and hash variables
    return view('account.wisata.reserv', compact('reserv', 'hash'));
}


public function reservation($id)
{
    $hash = new Hashids();
    $decodedId = $hash->decodeHex($id);
    $reservation = Reservation::where('reserv_id', $decodedId)->get();

    if ($reservation->isEmpty()) {
        return redirect()->back()->with('error', 'Data detail kuliner tidak ditemukan.');
    }

    return view('account.wisata.reservation', compact('reservation', 'hash'));
}



public function cekreserv()
{
    $hash = new Hashids();
    $company = auth()->user()->company;

    // Check if the company has a related akomodasi
    if (!$company || !$company->akomodasi || !$company->akomodasi->id) {
        // Redirect back with an error message if akomodasi_id is not available
        return redirect()->back()->with('maaf', 'Anda belum Mengisi Detail Kuliner.');
    }

    // Retrieve the akomodasi ID
    $akomodasiId = $company->akomodasi->id;
    $reserv = Reserv::where('akomodasi_id', $akomodasiId)->where('kodeboking', request()->kodeboking)->get();
    $reservation = Reserv::where('akomodasi_id', $akomodasiId)->get();
    
    if (isset(request()->kodeboking) && $reserv->count() > 0) {
        return redirect('wisata/reserv/' . request()->kodeboking);
    } else if (isset(request()->kodeboking) && $reserv->count() == 0) {
        return redirect('wisata/cekreserv ')->with('error', 'Kode tidak ditemukan !');
    } else {
        return view('account.wisata.reserv', compact('reservation', 'hash'));
    }
}
public function showreserv(Reserv $reserv)
{
    $reservation = Reservation::where('reserv_id', $reserv->id)->get();
    return view('account.wisata.showreserv', [
        'reserv' => $reserv,
        'reservation' => $reservation,
    ]);
}



public function checkin_reserv(Reserv $reserv)
{
Reserv::where('kodeboking', $reserv->kodeboking)->update(['statuspemakaian' => '11', 'payment_status' => '11']);
return redirect('wisata/reserv/' . $reserv->kodeboking)->with('success', 'Berhasil Checkin!');
}
    
}
