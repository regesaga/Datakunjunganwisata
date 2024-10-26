<?php
namespace App\Http\Controllers;
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
use App\Models\InstagramToken;
use App\Models\Htpaketwisata;
use App\Events\WisataViewEvent;
use App\Events\PaketWisataViewEvent;
use App\Models\ReviewRatingWisata;
use App\Models\ReviewRatingAkomodasi;
use App\Models\ReviewRatingKuliner;
use App\Models\ReviewRatingPaketwisata;
use App\Events\KulinerViewEvent;
use App\Events\AkomodasiViewEvent;
use App\Events\ArticleViewEvent;
use App\Events\RoomsViewEvent;
use App\Events\KulinerProdukViewEvent;
use App\Events\EvencalenderViewEvent;
use App\Events\EkrafViewEvent;
use App\Helpers\Cryptography;
use App\Models\HargaTiket;
use App\Models\Kecamatan;
use App\Models\Calenderevent;
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


class HomeController extends Controller
{

    private function makeCurlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

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


        return view('Home', compact(
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


    public function partnership()
    {
        return view('Kemitraan');
    }
  
 

    public function petawisata()
    {   
        $hash=new Hashids();
             
        $users = User::all();            

        $baner = Baner::where('judul', 'acara')->get(); 
        $wisatas = Wisata::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {
            $query->get();}])->get();
            $kuliners = Kuliner::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {
                $query->get();}])->get();
                $akomodasis = Akomodasi::where('active', 1)->with(['kecamatan', 'media' => function ($query) {$query->get();}])->get();
        
        $mapWisatas = $wisatas->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitude = $wisatas->count() && (request()->filled('namawisata') || request()->filled('search')) ? $wisatas->average('latitude') : -7.013805;
        $longitude = $wisatas->count() && (request()->filled('namawisata') || request()->filled('search')) ? $wisatas->average('longitude') : 108.570064;
        
        $mapKuliners = $kuliners->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitudekuliner = $kuliners->count() && (request()->filled('namakuliner') || request()->filled('search')) ? $kuliners->average('latitude') : -7.013805;
        $longtitudekuliner = $kuliners->count() && (request()->filled('namakuliner') || request()->filled('search')) ? $kuliners->average('longitude') : 108.570064;
        
        $mapAkomodasis = $akomodasis->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitudeakomodasi = $akomodasis->count() && (request()->filled('namaakomodasi') || request()->filled('search')) ? $akomodasis->average('latitude') : -7.013805;
        $longtitudeakomodasi = $akomodasis->count() && (request()->filled('namaakomodasi') || request()->filled('search')) ? $akomodasis->average('longitude') : 108.570064;
        $hash=new Hashids();


        $wisataData = collect($mapWisatas)->map(function ($wisata) use ($hash) {
            $wisata['encodedId'] = $hash->encode($wisata['id']); // Menggunakan encodedId sebagai properti yang dienkripsi
            return $wisata;
        });
        
        $encodedWisataData = json_encode($wisataData);
        
        $kulinerData = collect($mapKuliners)->map(function ($kuliner) use ($hash) {
            $kuliner['encodedId'] = $hash->encode($kuliner['id']); // Menggunakan encodedId sebagai properti yang dienkripsi
            return $kuliner;
        });
        $encodedKulinerData = json_encode($kulinerData);
        
        $akomodasiData = collect($mapAkomodasis)->map(function ($akomodasi) use ($hash) {
            $akomodasi['encodedId'] = $hash->encode($akomodasi['id']); // Menggunakan encodedId sebagai properti yang dienkripsi
            return $akomodasi;
        });
        $encodedAkomodasiData = json_encode($akomodasiData);
        
        return view('website.petawisata', compact('hash', 'wisatas', 'kuliners', 'akomodasis', 'mapWisatas', 'mapAkomodasis', 'mapKuliners', 'latitude', 'longitude', 'latitudeakomodasi', 'longtitudeakomodasi', 'latitudekuliner', 'longtitudekuliner', 'wisataData', 'kulinerData', 'akomodasiData'));
    }           

   

    public function showdetailpetawisata($encodedId)
    {
        $hash = new Hashids();
        $wisataId = $hash->decode($encodedId)[0];
        $wisata = Wisata::find($wisataId);
        if (is_null($wisata)) {
            return redirect()->route('home');
        }
        // Peningkatan jumlah views setelah mengambil data wisata
        event(new WisataViewEvent($wisata));

        $hargatiket = $wisata->hargatiket;
        $wisata->load('fasilitas', 'created_by');
        $latitude = $wisata->latitude;
        $longitude = $wisata->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        // dd($weatherData);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);

       // Ambil ulasan untuk wisata ini
       $reviews = ReviewRatingWisata::where('wisata_id', $wisata->id)
       ->where('status', 'active')
       ->get();

   // Periksa apakah pengguna sudah memberikan ulasan
   $userReview = null;
   $wisatawan = Auth::guard('wisatawans')->user();
   if ($wisatawan) {
       $userReview = ReviewRatingWisata::where('wisata_id', $wisata->id)
           ->where('wisatawan_id', $wisatawan->id)
           ->where('status', 'active')
           ->first();
   }

   return view('website.webdetailwisata', compact('wisata', 'hargatiket', 'hash', 'weatherData', 'imageName', 'temperatureCelsius', 'windSpeedMeterPerSecond', 'reviews', 'userReview'));
}


    public function showdetailpetakuliner($encodedId)
    {
        $hash = new Hashids();
        $kulinerId = $hash->decode($encodedId)[0];
        $kuliner = Kuliner::find($kulinerId);
        if(is_null($kuliner)){
            return redirect()->route('home');
        }
        $kulinerproduk = $kuliner->kulinerproduk()->where('active', 1)->get();
        $latitude = $kuliner->latitude;
        $longitude = $kuliner->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);


        // Peningkatan jumlah views setelah mengambil data kuliner
        event(new KulinerViewEvent($kuliner));

        $kecamatan = Kecamatan::all();
          // Ambil ulasan untuk wisata ini
          $reviews = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
          ->where('status', 'active')
          ->get();
  
      // Periksa apakah pengguna sudah memberikan ulasan
             $userReview = null;
             $wisatawan = Auth::guard('wisatawans')->user();
             if ($wisatawan) {
                 $userReview = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
                     ->where('wisatawan_id', $wisatawan->id)
                     ->where('status', 'active')
                     ->first();
             }
 
         return view('website.webdetailkuliner', compact('userReview','reviews','kuliner','kulinerproduk', 'kecamatan', 'hash', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
     }


    public function showdetailkuliner($kuliner)
{
    $hash = new Hashids();
    $kulinerId = $hash->decodeHex($kuliner);
    $kuliner = Kuliner::find($kulinerId);
    if (is_null($kuliner)) {
        return redirect()->route('home');
    }
    $kulinerproduk = $kuliner->kulinerproduk()->where('active', 1)->get();

    $latitude = $kuliner->latitude;
    $longitude = $kuliner->longitude;
    $weatherData = $this->getWeatherData($latitude, $longitude);
    $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
    $imageName = $this->chooseWeatherImage($weatherCode);
    $temperatureKelvin = $weatherData['main']['temp'];
    $temperatureCelsius = $temperatureKelvin - 273.15;
    $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
    $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
    $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
    $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);

    // Peningkatan jumlah views setelah mengambil data kuliner
    event(new KulinerViewEvent($kuliner));

    $kecamatan = Kecamatan::all();

    // Ambil ulasan untuk wisata ini
    $reviews = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
        ->where('status', 'active')
        ->get();

    // Periksa apakah pengguna sudah memberikan ulasan
    $userReview = null;
    $wisatawan = Auth::guard('wisatawans')->user();
    if ($wisatawan) {
        $userReview = ReviewRatingKuliner::where('kuliner_id', $kuliner->id)
            ->where('wisatawan_id', $wisatawan->id)
            ->where('status', 'active')
            ->first();
    }

    return view('website.webdetailkuliner', compact('userReview', 'reviews', 'kuliner', 'kulinerproduk', 'kecamatan', 'hash', 'weatherData', 'imageName', 'temperatureCelsius', 'windSpeedMeterPerSecond'));
}

    // Method to store review
 public function reviewstorekuliner(Request $request, $kuliner)
 {
     // Authenticate wisatawan
     $wisatawan = Auth::guard('wisatawans')->user();
     if (!$wisatawan) {
         return redirect()->route('wisatawan.login')->with('message', 'Silakan login sebagai wisatawan.');
     }
 
     // Validate request data
     $request->validate([
         'comment' => 'nullable|string',
         'rating' => 'required|integer|min:1|max:5',
     ]);
 
     // Decode wisata ID from hash
     $hash = new Hashids();
     $kulinerId = $hash->decodeHex($kuliner);
 
     // Create new review
     $review = new ReviewRatingKuliner();
     $review->kuliner_id = $kulinerId;
     $review->comments = $request->comment;
     $review->star_rating = $request->rating;
     $review->wisatawan_id = $wisatawan->id;
     $review->status = 'active'; // Assuming you want to set it active by default
     $review->save();
 
     return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
 }
 
 
 public function reviewupdatekuliner(Request $request, $kuliner, $id)
 {
     $request->validate([
         'comment' => 'required|string',
         'rating' => 'required|integer|min:1|max:5',
     ]);
 
     $review = ReviewRatingKuliner::findOrFail($id);
 
     // Pastikan hanya pemilik ulasan yang bisa melakukan update
     if ($review->wisatawan_id !== auth()->guard('wisatawans')->id()) {
         return redirect()->back()->with('error', 'Unauthorized action.');
     }
 
     // Lakukan update ulasan
     $review->update([
         'comments' => $request->comment,
         'star_rating' => $request->rating,
     ]);
 
     // Redirect kembali ke halaman detail wisata
     $hash = new Hashids();
     $hashedKulinerId = $hash->encodeHex($review->kuliner->id);
 
     return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
 }

   


    public function showdetailpetaakomodasi($encodedId)
    {
        $hash = new Hashids();
        $akomodasiId = $hash->decode($encodedId)[0];
        $akomodasi = Akomodasi::find($akomodasiId);
        $room = $akomodasi->room()->where('active', 1)->get();
        $latitude = $akomodasi->latitude;
        $longitude = $akomodasi->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);


        // Peningkatan jumlah views setelah mengambil data akomodasi
        event(new AkomodasiViewEvent($akomodasi));

        $akomodasi->load('fasilitas', 'created_by');

              // Ambil ulasan untuk wisata ini
              $reviews = ReviewRatingAkomodasi::where('akomodasi_id', $akomodasi->id)
              ->where('status', 'active')
              ->get();
      
          // Periksa apakah pengguna sudah memberikan ulasan
                 $userReview = null;
                 $wisatawan = Auth::guard('wisatawans')->user();
                 if ($wisatawan) {
                     $userReview = ReviewRatingAkomodasi::where('akomodasi_id', $akomodasi->id)
                         ->where('wisatawan_id', $wisatawan->id)
                         ->where('status', 'active')
                         ->first();
                 }
    
            return view('website.webdetailakomodasi', compact('userReview','reviews','room','akomodasi', 'hash', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
        }

        
    
    public function showdetailakomodasi($akomodasi)
    {
        $hash = new Hashids();
        $akomodasiId = $hash->decodeHex($akomodasi);
        $akomodasi = Akomodasi::find($akomodasiId);
        if(is_null($akomodasi)){
            return redirect()->route('home');
        }
        $room = $akomodasi->room()->where('active', 1)->get();
        $latitude = $akomodasi->latitude;
        $longitude = $akomodasi->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);


        // Peningkatan jumlah views setelah mengambil data akomodasi
        event(new AkomodasiViewEvent($akomodasi));

        $akomodasi->load('fasilitas', 'created_by');

          // Ambil ulasan untuk wisata ini
          $reviews = ReviewRatingAkomodasi::where('akomodasi_id', $akomodasi->id)
          ->where('status', 'active')
          ->get();
  
      // Periksa apakah pengguna sudah memberikan ulasan
             $userReview = null;
             $wisatawan = Auth::guard('wisatawans')->user();
             if ($wisatawan) {
                 $userReview = ReviewRatingAkomodasi::where('akomodasi_id', $akomodasi->id)
                     ->where('wisatawan_id', $wisatawan->id)
                     ->where('status', 'active')
                     ->first();
             }

        return view('website.webdetailakomodasi', compact('userReview','reviews','room','akomodasi', 'hash', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
    }

      // Method to store review
 public function reviewstoreakomodasi(Request $request, $akomodasi)
 {
     // Authenticate wisatawan
     $wisatawan = Auth::guard('wisatawans')->user();
     if (!$wisatawan) {
         return redirect()->route('wisatawan.login')->with('message', 'Silakan login sebagai wisatawan.');
     }
 
     // Validate request data
     $request->validate([
         'comment' => 'nullable|string',
         'rating' => 'required|integer|min:1|max:5',
     ]);
 
     // Decode wisata ID from hash
     $hash = new Hashids();
     $akomodasiId = $hash->decodeHex($akomodasi);
 
     // Create new review
     $review = new ReviewRatingAkomodasi();
     $review->akomodasi_id = $akomodasiId;
     $review->comments = $request->comment;
     $review->star_rating = $request->rating;
     $review->wisatawan_id = $wisatawan->id;
     $review->status = 'active'; // Assuming you want to set it active by default
     $review->save();
 
     return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
 }
 
 
 public function reviewupdateakomodasi(Request $request, $akomodasi, $id)
 {
     $request->validate([
         'comment' => 'required|string',
         'rating' => 'required|integer|min:1|max:5',
     ]);
 
     $review = ReviewRatingAkomodasi::findOrFail($id);
 
     // Pastikan hanya pemilik ulasan yang bisa melakukan update
     if ($review->wisatawan_id !== auth()->guard('wisatawans')->id()) {
         return redirect()->back()->with('error', 'Unauthorized action.');
     }
 
     // Lakukan update ulasan
     $review->update([
         'comments' => $request->comment,
         'star_rating' => $request->rating,
     ]);
 
     // Redirect kembali ke halaman detail wisata
     $hash = new Hashids();
     $hashedAkomodasiId = $hash->encodeHex($review->akomodasi->id);
 
     return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
 }


    public function showdetailkulinerproduk($kulinerproduk)
    {
        $hash = new Hashids();
        $kulinerprodukId = $hash->decodeHex($kulinerproduk);
        $kulinerproduk = KulinerProduk::find($kulinerprodukId);
        if(is_null($kulinerproduk)){
            return redirect()->route('home');
        }

        // Peningkatan jumlah views setelah mengambil data kulinerproduk
        event(new KulinerprodukViewEvent($kulinerproduk));

        $kulinerproduk->load('fasilitas', 'created_by');
        return view('website.webdetailkulinerproduk', compact('kulinerproduk','hash'))->with([
            'hash' => $hash,
            'kulinerproduk' => $kulinerproduk
        ]);
    }

    public function showdetailpaketwisata($paketwisata)
    {
        $hash = new Hashids();
        $paketwisataId = $hash->decodeHex($paketwisata);
        $paketwisata = PaketWisata::find($paketwisataId);
        if(is_null($paketwisata)){
            return redirect()->route('home');
        }

        $htpaketwisata = $paketwisata->htpaketwisata;
        $baner = Baner::where('judul', 'destinasi')->get();
        // Peningkatan jumlah views setelah mengambil data paketwisata
        event(new PaketWisataViewEvent($paketwisata));
         // Ambil ulasan untuk wisata ini
         $reviews = ReviewRatingPaketwisata::where('paketwisata_id', $paketwisata->id)
         ->where('status', 'active')
         ->get();
 
     // Periksa apakah pengguna sudah memberikan ulasan
            $userReview = null;
            $wisatawan = Auth::guard('wisatawans')->user();
            if ($wisatawan) {
                $userReview = ReviewRatingPaketwisata::where('paketwisata_id', $paketwisata->id)
                    ->where('wisatawan_id', $wisatawan->id)
                    ->where('status', 'active')
                    ->first();
            }

        return view('website.webdetailpaketwisata', compact('userReview','reviews','paketwisata','baner','hash','htpaketwisata'));
    }

         // Method to store review
 public function reviewstorepaketwisata(Request $request, $paketwisata)
 {
     // Authenticate wisatawan
     $wisatawan = Auth::guard('wisatawans')->user();
     if (!$wisatawan) {
         return redirect()->route('wisatawan.login')->with('message', 'Silakan login sebagai wisatawan.');
     }
 
     // Validate request data
     $request->validate([
         'comment' => 'nullable|string',
         'rating' => 'required|integer|min:1|max:5',
     ]);
 
     // Decode wisata ID from hash
     $hash = new Hashids();
     $paketwisataId = $hash->decodeHex($paketwisata);
 
     // Create new review
     $review = new ReviewRatingPaketwisata();
     $review->paketwisata_id = $paketwisataId;
     $review->comments = $request->comment;
     $review->star_rating = $request->rating;
     $review->wisatawan_id = $wisatawan->id;
     $review->status = 'active'; // Assuming you want to set it active by default
     $review->save();
 
     return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
 }
 
 
 public function reviewupdatepaketwisata(Request $request, $paketwisata, $id)
 {
     $request->validate([
         'comment' => 'required|string',
         'rating' => 'required|integer|min:1|max:5',
     ]);
 
     $review = ReviewRatingPaketwisata::findOrFail($id);
 
     // Pastikan hanya pemilik ulasan yang bisa melakukan update
     if ($review->wisatawan_id !== auth()->guard('wisatawans')->id()) {
         return redirect()->back()->with('error', 'Unauthorized action.');
     }
 
     // Lakukan update ulasan
     $review->update([
         'comments' => $request->comment,
         'star_rating' => $request->rating,
     ]);
 
     // Redirect kembali ke halaman detail wisata
     $hash = new Hashids();
     $hashedAkomodasiId = $hash->encodeHex($review->paketwisata->id);
 
     return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
 }



    public function showdetailroom($room)
    {
        $hash = new Hashids();
        $roomId = $hash->decodeHex($room);
        $room = Rooms::find($roomId);
        if(is_null($room)){
            return redirect()->route('home');
        }

        // Peningkatan jumlah views setelah mengambil data room
        event(new RoomsViewEvent($room));

        $room->load('fasilitas', 'created_by');
        return view('website.webdetailroom', compact('room','hash'))->with([
            'hash' => $hash,
            'room' => $room
        ]);
    }

    public function showdetailekraf($ekraf)
    {
        $hash = new Hashids();
        $ekrafId = $hash->decodeHex($ekraf);
        $ekraf = Ekraf::find($ekrafId);
        if(is_null($ekraf)){
            return redirect()->route('home');
        }

        // Peningkatan jumlah views setelah mengambil data ekraf
        event(new EkrafViewEvent($ekraf));

        $ekraf->load('fasilitas', 'created_by');
        return view('website.webdetailekraf', compact('ekraf','hash'))->with([
            'hash' => $hash,
            'ekraf' => $ekraf
        ]);
    }



    public function destinasi(Request $request)
    {
        $hash=new Hashids();
        // $Cryptography = new Cryptography();
        $wisatas = Wisata::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {
        $query->get();}]);
        if ($request->keyword != null) {
            $wisatas->where('namawisata', 'like', '%' . $request->keyboard . '%');
        }
        if ($request->cat_list != null) {
            $wisatas->whereIn('categorywisata_id', $request->cat_list);
        }
        $wisatas = $wisatas->paginate(9);
        $cateegoryWisata = CategoryWisata::select('id','category_name')->get();
        $paketwisata = PaketWisata::where('active', 1)->with('media')->get();

        
        $htpaketwisata = Htpaketwisata::all();
        $baner = Baner::where('judul', 'destinasi')->get();
    
        return view('website.destinasi',compact('baner','wisatas','hash','cateegoryWisata','paketwisata','htpaketwisata'));
    }

    public function showdetailwisata($wisata)
    {
        $hash = new Hashids();
        // Decode wisata ID dari hash
        $wisataId = $hash->decodeHex($wisata);
        $wisata = Wisata::find($wisataId);
        if (is_null($wisata)) {
            return redirect()->route('home');
        }
    
        // Peningkatan jumlah views setelah mengambil data wisata
        event(new WisataViewEvent($wisata));
    
        // Load related data
        $hargatiket = $wisata->hargatiket;
        $wisata->load('fasilitas', 'created_by');
    
        // Get weather data
        $latitude = $wisata->latitude;
        $longitude = $wisata->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = number_format($windSpeedKilometerPerHour * 0.27777777778, 2);
    
        // Ambil ulasan untuk wisata ini
        $reviews = ReviewRatingWisata::where('wisata_id', $wisata->id)
            ->where('status', 'active')
            ->get();
    
        // Periksa apakah pengguna sudah memberikan ulasan
        $userReview = null;
        $wisatawan = Auth::guard('wisatawans')->user();
        if ($wisatawan) {
            $userReview = ReviewRatingWisata::where('wisata_id', $wisata->id)
                ->where('wisatawan_id', $wisatawan->id)
                ->where('status', 'active')
                ->first();
        }
    
        return view('website.webdetailwisata', compact('reviews', 'userReview','wisata', 'hargatiket', 'hash', 'weatherData', 'imageName', 'temperatureCelsius', 'windSpeedMeterPerSecond'));
    }
    
    


  // Method to store review
 public function reviewstore(Request $request, $wisata)
{
    // Authenticate wisatawan
    $wisatawan = Auth::guard('wisatawans')->user();
    if (!$wisatawan) {
        return redirect()->route('wisatawan.login')->with('message', 'Silakan login sebagai wisatawan.');
    }

    // Validate request data
    $request->validate([
        'comment' => 'nullable|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // Decode wisata ID from hash
    $hash = new Hashids();
    $wisataId = $hash->decodeHex($wisata);

    // Create new review
    $review = new ReviewRatingWisata();
    $review->wisata_id = $wisataId;
    $review->comments = $request->comment;
    $review->star_rating = $request->rating;
    $review->wisatawan_id = $wisatawan->id;
    $review->status = 'active'; // Assuming you want to set it active by default
    $review->save();

    return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
}


public function reviewupdate(Request $request, $wisata, $id)
{
    $request->validate([
        'comment' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $review = ReviewRatingWisata::findOrFail($id);

    // Pastikan hanya pemilik ulasan yang bisa melakukan update
    if ($review->wisatawan_id !== auth()->guard('wisatawans')->id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Lakukan update ulasan
    $review->update([
        'comments' => $request->comment,
        'star_rating' => $request->rating,
    ]);

    // Redirect kembali ke halaman detail wisata
    $hash = new Hashids();
    $hashedWisataId = $hash->encodeHex($review->wisata->id);

    return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
}


    public function kuliner(Request $request)
    {
        $hash=new Hashids();
        $kuliner = Kuliner::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {$query->get();}]);
        if (isset($request->category)){
            $kuliner->where('categorykuliner_id', $request->category);
        }
        if (isset($request->keyword)){
            $kuliner->where('namakuliner','like', '%' . $request->keyword . '%');
        }
        $kuliner = $kuliner->paginate(9);
        $baner = Baner::where('judul', 'kuliner')->get();
        $categoryKuliner = CategoryKuliner::select('id', 'category_name')->get();
        return view('website.kuliner',compact('baner','kuliner','hash','categoryKuliner'));
    }

    public function dataKuliner(Request $request)
    {
        $kuliner = Kuliner::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {$query->get();}]);
        if (($request->category)){
            $kuliner->where('categorykuliner_id', $request->category);
        }
        $kuliner = $kuliner->paginate(9);
        return $kuliner;
        // $kuliner = $kuliner->get();
        // dd($kuliner);
    }

    public function akomodasi(Request $request)
    {
        $hash=new Hashids();
        $akomodasi = Akomodasi::where('active', 1)->with(['kecamatan', 'media' => function ($query) {$query->get();}]);
        if (isset($request->keyword)){
            $akomodasi->where('namaakomodasi','like', '%' . $request->keyword . '%');
        }
        if (isset($request->cat_list)){
            
            $akomodasi->whereIn('categoryakomodasi_id', $request->cat_list);

        }

        $akomodasi = $akomodasi->paginate(6);

        $category_akomondasi = CategoryAkomodasi::get();
        $baner = Baner::where('judul', 'akomodasi')->get();
        return view('website.akomodasi',compact('baner','akomodasi','hash','category_akomondasi'));
    }

    public function event(Request $request)
    {
        $hash=new Hashids();
        $event = Evencalender::where('active', 1)->with(['media' => function ($query) {$query->get();}]);
        if (isset($request->keyword)){
            $event->where('title','like', '%' . $request->keyword . '%');
        }
        if (isset($request->order)) {
            if ($request->order == 1){ // untuk kondisi tanggal event terlama
                $event->orderBy('created_at', 'asc');
            }
            if ($request->order == 2){ // untuk kondisi tanggal event terbrau
                $event->orderBy('created_at', 'desc');
            }
            if ($request->order == 3){ // untuk kondisi nama event dari A - Z
                $event->orderBy('title', 'asc');
            }
            if ($request->order == 4){ // untuk kondisi nama event dari Z - A
                $event->orderBy('title', 'desc');
            }
        }

        $event = $event->paginate(3);
        // dd($event);
        $baner = Baner::where('judul', 'acara')->get();
        return view('website.event',compact('baner','event','hash'));
    }

    public function articel(Request $request)
    {
        $hash=new Hashids();
        $articel = Article::where('active', 1)->with(['media' => function ($query) {$query->get();}]);
        if (isset($request->keyword)){
            $articel->where('title','like', '%' . $request->keyword . '%');
        }
        if (isset($request->order)) {
            if ($request->order == 1){ // untuk kondisi tanggal articel terlama
                $articel->orderBy('tanggalmulai', 'desc');
            }
            if ($request->order == 2){ // untuk kondisi tanggal articel terbrau
                $articel->orderBy('tanggalmulai', 'asc');
            }
            if ($request->order == 3){ // untuk kondisi nama articel dari A - Z
                $articel->orderBy('title', 'asc');
            }
            if ($request->order == 4){ // untuk kondisi nama articel dari Z - A
                $articel->orderBy('title', 'asc');
            }
        }

        $articel = $articel->paginate(6);
        $baner = Baner::where('judul', 'artikel')->get();
        return view('website.articel',compact('baner','articel','hash'));
    }

    public function showdetailarticel($article)
    {
        $hash = new Hashids();
        $articleId = $hash->decodeHex($article);
        $article = Article::find($articleId);
        if(is_null($article)){
            return redirect()->route('home');
        }

        $tag = Tag::all();
        $baner = Baner::where('judul', 'artikel')->get();
        $articel = Article::where('active', 1)->with(['media' => function ($query) {$query->get();}]);
        if (isset($request->keyword)){
            $articel->where('title','like', '%' . $request->keyword . '%');
        }
        if (isset($request->order)) {
            if ($request->order == 1){ // untuk kondisi tanggal articel terlama
                $articel->orderBy('tanggalmulai', 'desc');
            }
            if ($request->order == 2){ // untuk kondisi tanggal articel terbrau
                $articel->orderBy('tanggalmulai', 'asc');
            }
            if ($request->order == 3){ // untuk kondisi nama articel dari A - Z
                $articel->orderBy('title', 'asc');
            }
            if ($request->order == 4){ // untuk kondisi nama articel dari Z - A
                $articel->orderBy('title', 'asc');
            }
        }

        $articel = $articel->paginate(6);

        // Peningkatan jumlah views setelah mengambil data article
        event(new ArticleViewEvent($article));

        
        return view('website.webdetailarticel', compact('article','hash','tag','baner','articel'))->with([
            'hash' => $hash,
            'baner' => $baner,
            'tag' => $tag
        ]);
    }


   

    public function showdetailevencalender($event)
    {
        $hash = new Hashids();
        $wisataId = $hash->decodeHex($event);
        $event = Evencalender::find($wisataId);
        if(is_null($event)){
            return redirect()->route('home');
        }

        $baner = Baner::all();
        $latitude = $event->latitude;
        $longitude = $event->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);

        // dd($event);
        return view('website.webdetailevent', compact('event','hash', 'baner','weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
    }

 

 

    

 
}
