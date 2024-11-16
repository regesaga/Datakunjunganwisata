<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\Akomodasi;
use App\Models\Kuliner;
use App\Models\Tag;
use App\Models\Ekraf;
use App\Models\Pesantiket;
use App\Models\Pesanantiket;
use App\Models\Pesanankuliner;
use App\Models\Pesankuliner;
use App\Models\Reserv;
use App\Models\Reservation;
use App\Models\Company;
use App\Models\Wisatawan;
use App\Models\Baner;
use App\Models\Article;
use App\Models\Fasilitas;
use App\Models\BanerPromo;
use App\Models\Evencalender;
use App\Models\KulinerProduk;
use App\Models\PaketWisata;
use App\Models\Rooms;
use App\Models\CategoryWisata;
use App\Models\CategoryKuliner;
use App\Models\CategoryAkomodasi;
use App\Models\Support;
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

class AdminController extends Controller
{
        
    public function index()
    {   
        $hash=new Hashids();
        $jumlah_post = Article::count();
        $jumlah_tag = Tag::count();
        $jumlah_banner = Baner::count();
        $jumlah_user = User::count();

        $jumlah_Tiket = Pesantiket::count();
        $jumlah_PesanKuliner = Pesankuliner::count();
        $jumlah_Reservasi = Reserv::count();

        $jumlah_wisata = Wisata::count();
        $jumlah_pesanan_tiket_wisata = Pesantiket::count();
        $jumlah_kuliner = Kuliner::count();
        $jumlah_akomodasi = Akomodasi::count();
        $jumlah_ekraf = Ekraf::count();
        $jumlah_company = Company::count();
        $jumlah_wisatawan = Wisatawan::count();
        $jumlah_role = Role::count();
        $jumlah_permission = Permission::count();

        $jumlah_paket_wisata = PaketWisata::count();
        $jumlah_proudct_kuliner = KulinerProduk::count();
        $jumlah_room = Rooms::count();
        $jumlah_event = Evencalender::count();
        $jumlah_baner_promo = BanerPromo::count();
        $jumlah_support = Support::count();
        $jumlah_fasilitas = Fasilitas::count();
        $jumlah_jeniswisata = CategoryWisata::count();
        $jumlah_jeniskuliner = CategoryKuliner::count();
        $jumlah_jenisakomodasi = CategoryAkomodasi::count();

        $hari_ini = Carbon::today();
        $post = Article::select('id', 'judul', 'sampul')->whereDate('created_at', $hari_ini)->get();
        $tag = Tag::select('nama', 'slug')->whereDate('created_at', $hari_ini)->get();
        $banner = Baner::select('sampul', 'judul')->whereDate('created_at', $hari_ini)->get();

        $wisatas = Wisata::all();   
        $kuliners = Kuliner::all();            
        $akomodasis = Akomodasi::all();            
        $users = User::all();            
        $authors = User::role('admin')->with('company')->paginate(30);
        $roles = Role::all()->pluck('name');
        $permissions = Permission::all()->pluck('name');
        $rolesHavePermissions = Role::with('permissions')->get();


        $mapWisatas = $wisatas->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitude = $wisatas->count() && (request()->filled('namawisata') || request()->filled('search')) ? $wisatas->average('latitude') : -7.013805;
        $longitude = $wisatas->count() && (request()->filled('namawisata') || request()->filled('search')) ? $wisatas->average('longitude') : 108.570064;

        $mapKuliners = $kuliners->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitudekuliner = $kuliners->count() && (request()->filled('namakuliner') || request()->filled('search')) ? $kuliners->average('latitude') : -7.013805;
        $longtitudekuliner = $kuliners->count() && (request()->filled('namakuliner') || request()->filled('search')) ? $kuliners->average('longitude') : 108.570064;

        $mapAkomodasis = $akomodasis->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitudeakomodasi = $akomodasis->count() && (request()->filled('namaakomodasi') || request()->filled('search')) ? $akomodasis->average('latitude') : -7.013805;
        $longtitudeakomodasi = $akomodasis->count() && (request()->filled('namaakomodasi') || request()->filled('search')) ? $akomodasis->average('longitude') : 108.570064;


        return view('admin.user-account', compact(
            'hash',
            'jumlah_paket_wisata',
            'jumlah_proudct_kuliner',
            'jumlah_room',
            'jumlah_event',
            'jumlah_baner_promo',
            'jumlah_support',

            'jumlah_Tiket',
            'jumlah_PesanKuliner',
            'jumlah_Reservasi',
            
            'jumlah_fasilitas',
            'jumlah_jeniswisata',
            'jumlah_jeniskuliner',
            'jumlah_jenisakomodasi',
            'jumlah_role',
            'jumlah_permission',

            'jumlah_akomodasi',
            'jumlah_pesanan_tiket_wisata',
            'jumlah_user',
            'jumlah_wisata', 
            'jumlah_wisatawan', 
            'jumlah_company', 
            'jumlah_kuliner',
            'jumlah_ekraf', 
            'jumlah_post', 
            'jumlah_tag',
            'jumlah_banner', 
            'post',
            'tag', 
            'banner',
            'wisatas',
            'kuliners',
            'akomodasis',
            'users', 
            'mapWisatas',
            'mapAkomodasis',
            'mapKuliners', 
            'latitude', 
            'longitude',
            'latitudeakomodasi', 
            'longtitudeakomodasi',
            'latitudekuliner', 
            'longtitudekuliner',
        ));
    }

    public function show(Wisata $wisata)
    {

        return view('admin.detailwisata', compact('wisata'));
    }

    public function showUser(User $user)
    {

        return view('user', compact('user'));
    }

    public function showkuliner(Kuliner $kuliner)
    {

        return view('kuliner', compact('kuliner'));
    }

    public function showakomodasi(Akomodasi $akomodasi)
    {

        return view('akomodasi', compact('akomodasi'));
    }
    

  
   


    

    public function changePasswordView()
    {
        return view('admin.change-password');
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
                    Alert::toast('Password Berhasil di Ubah!', 'success');
                    return redirect()->route('admin.changePassword');
                } else {
                    Alert::toast('Ada Kesalahan!', 'warning');
                }
            } else {
                Alert::toast('Passwords Tidaksama!', 'info');
            }
        } else {
            Alert::toast('Password Salah!', 'info');
        }
        return redirect()->back();
    }

  

   

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

 
}
