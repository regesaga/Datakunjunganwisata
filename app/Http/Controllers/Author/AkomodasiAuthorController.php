<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Wisatawan;
use App\Models\Evencalender;
use App\Models\CategoryEvencalender;
use App\Models\CategoryAkomodasi;
use App\Models\CategoryRooms;
use App\Models\Akomodasi;
use App\Models\Reserv;
use App\Models\Reservation;
use App\Models\Rooms;
use App\Models\Company;
use App\Models\Kecamatan;
use App\Models\BanerPromo;
use App\Models\Fasilitas;
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

class AkomodasiAuthorController extends Controller
{

    use MediaUploadingTrait;
   
    public function index()
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
    return view('account.akomodasi.user-akomodasi', compact('akomodasi', 'company'))->with([
        'company' => $company,
        'dashCount' => $dashCount,
        'akomodasi' => $akomodasi
    ]);
}


    public function changePasswordView()
    {
        $user = auth()->user(); // Get the authenticated user

        return view('account.akomodasi.ganti-password');
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
                    return redirect()->route('account.akomodasi.user-akomodasi');
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
        return view('account.akomodasi.company.create');
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
    return redirect()->route('account.akomodasi.user-akomodasi');
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
        return view('account.akomodasi.company.edit', compact('company'))->with([
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
    
        return redirect()->route('account.akomodasi.user-akomodasi')->with('success', 'Data perusahaan berhasil diperbarui');
    }

    public function destroy()
    {
        Storage::delete('public/companies/logos/' . basename(auth()->user()->company->logo));
        if (auth()->user()->company->delete()) {
            return redirect()->route('account.akomodasi.user-akomodasi');
        }
        return redirect()->route('account.akomodasi.user-akomodasi');
    }

    protected function hasCompany()
    {
        return auth()->user()->company !== null;
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
    
        return view('account.akomodasi.akomodasi.create', compact('company', 'categories', 'fasilitas', 'kecamatan'));
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
            
            return redirect()->route('account.akomodasi.user-akomodasi')->with('status', 'Data Berhasil Di Input');
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
    
        return view('account.akomodasi.akomodasi.edit', compact('akomodasi', 'fasilitas', 'categories', 'kecamatan'));
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
            
            return redirect()->route('account.akomodasi.user-akomodasi')->with('status', 'Data Berhasil Di Input');
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
        
        return view('account.akomodasi.room.index', compact('rooms','hash', 'categories','fasilitas'));
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
    
            return redirect()->route('account.akomodasi.room.index')->with('status', 'Data Berhasil Di Input');
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
        
        return view('account.akomodasi.room.create',  compact('akomodasi', 'categories','fasilitas'));
    }

    public function showroom($room)
    {
        $hash=new Hashids();
        $room = Rooms::find($hash->decodeHex($room));
        $room->load('fasilitas', 'created_by');
        return view('account.akomodasi.room.show', compact('room','hash'));
    }


    public function showdetailroom($id)
    {
        $room = Rooms::find($id);
        $room->load('fasilitas', 'created_by');
        return view('account.akomodasi.detailroom', compact('room'));
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
        return view('account.akomodasi.room.edit', compact( 'room','akomodasi','fasilitas', 'categories'))->with([
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
            
            return redirect()->route('account.akomodasi.room.index')->with('status', 'Data Berhasil Di Input');
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


        return view('account.akomodasi.fasilitas.index', compact('fasilitas','hash'));
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
        return redirect()->route('account.akomodasi.fasilitas.index');
    }


    public function createfasilitas()
    {

        return view('account.akomodasi.fasilitas.create');
    }

    public function editfasilitas($fasilitas)
    {
        $hash=new Hashids();
        $fasilitas = Fasilitas::find($hash->decodeHex($fasilitas));
        return view('account.akomodasi.fasilitas.edit', compact('fasilitas','hash'))->with([
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
        return redirect()->route('account.akomodasi.fasilitas.index');
    }

    public function destroyfasilitas($id)
    {
        $fasilitas = Fasilitas::find($id);
        $fasilitas->delete();
        Alert::toast('Fasilitas Delete!', 'success');
        return redirect()->route('account.akomodasi.fasilitas.index');
    }
 
   

        public function GetBanerpromo()
        {
            $hash=new Hashids();
            $akomodasi = null;
            $dashCount['room'] = null;
        
            if ($this->hasCompany()) {
                $company = auth()->user()->company;
            }
        
            if ($this->hasAkomodasi()) {
                $akomodasi = auth()->user()->company->akomodasi;
                $dashCount['room'] = Rooms::where('akomodasi_id', $akomodasi->id)->count();
            }
            $banerpromo = BanerPromo::all();
            return view('account.akomodasi.banerpromo.index', compact('banerpromo','hash','akomodasi', 'dashCount'));
        }
    
    
            public function createBanerpromo()
                {
                     return view('account.akomodasi.banerpromo.create');
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
                    return redirect()->route('account.akomodasi.banerpromo.index');
                }
    
                
     
        public function showBanerpromo($banerpromo)
        {
                        $hash=new Hashids();
                        $banerpromo = BanerPromo::find($hash->decodeHex($banerpromo));
                        return view('account.akomodasi.banerpromo.show', compact('banerpromo','hash'));
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
            return view('account.akomodasi.banerpromo.edit', compact( 'banerpromo','hash'))->with([
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
            return redirect()->route('account.akomodasi.banerpromo.index');
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
        return view('account.akomodasi.getwisatawan', compact('wisatawan', 'hash'));
    }

    public function getAllEven()
    {
        $hash = new Hashids();
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
        $id = Auth::id();
        $even = Evencalender::where('created_by_id', $id)->get();
        return view('account.akomodasi.even.index', compact('even','akomodasi', 'company','hash'))->with([
            'company' => $company,
            'dashCount' => $dashCount,
            'akomodasi' => $akomodasi
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
    
            return redirect()->route('account.akomodasi.even.index');
        } catch (\Exception $e) {
            Log::error('Error creating even', ['error' => $e->getMessage()]);
            return back()->withError('Error creating even')->withInput();
        }
    }



    public function createEven()
    {

        return view('account.akomodasi.even.create');
    }

    public function showeven($even)
    {
        $hash = new Hashids();
        $even = Evencalender::find($hash->decodeHex($even));
        return view('account.akomodasi.even.show', compact('even', 'hash'));
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
        return view('account.akomodasi.even.edit', compact('even'))->with([
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
    
            return redirect()->route('account.akomodasi.even.index');
        } catch (\Exception $e) {
            Log::error('Error updating even', ['error' => $e->getMessage()]);
            return back()->withError('Error updating even')->withInput();
        }
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
    return view('account.akomodasi.reserv', compact('reserv', 'hash'));
}


public function reservation($id)
{
    $hash = new Hashids();
    $decodedId = $hash->decodeHex($id);
    $reservation = Reservation::where('reserv_id', $decodedId)->get();

    if ($reservation->isEmpty()) {
        return redirect()->back()->with('error', 'Data detail kuliner tidak ditemukan.');
    }

    return view('account.akomodasi.reservation', compact('reservation', 'hash'));
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
        return redirect('akomodasi/reserv/' . request()->kodeboking);
    } else if (isset(request()->kodeboking) && $reserv->count() == 0) {
        return redirect('akomodasi/cekreserv ')->with('error', 'Kode tidak ditemukan !');
    } else {
        return view('account.akomodasi.reserv', compact('reservation', 'hash'));
    }
}
public function showreserv(Reserv $reserv)
{
    $reservation = Reservation::where('reserv_id', $reserv->id)->get();
    return view('account.akomodasi.showreserv', [
        'reserv' => $reserv,
        'reservation' => $reservation,
    ]);
}



public function checkin_reserv(Reserv $reserv)
{
Reserv::where('kodeboking', $reserv->kodeboking)->update(['statuspemakaian' => '11', 'payment_status' => '11']);
return redirect('akomodasi/reserv/' . $reserv->kodeboking)->with('success', 'Berhasil Checkin!');
}

}
