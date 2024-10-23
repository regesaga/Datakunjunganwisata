<?php
namespace App\Http\Controllers;
use App\Models\InstagramToken;
use App\Events\WisataViewEvent;
use App\Events\KulinerViewEvent;
use App\Events\AkomodasiViewEvent;
use App\Events\ArticleViewEvent;
use App\Events\RoomsViewEvent;
use App\Events\KulinerProdukViewEvent;
use App\Events\EvencalenderViewEvent;
use App\Events\EkrafViewEvent;
use App\Models\Wisata;
use App\Models\User;
use App\Models\HargaTiket;
use App\Models\Kecamatan;
use App\Models\Akomodasi;
use App\Models\Kuliner;
use App\Models\KulinerProduk;
use App\Models\Tag;
use App\Models\Ekraf;
use App\Models\Fasilitas;
use App\Models\PaketWisata;
use App\Models\Calenderevent;
use App\Models\Rooms;
use App\Models\Baner;
use App\Models\Article;
use Hashids\Hashids;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;


class KulinerController extends Controller
{

   

    public function index()
    {
        return view('Home');
    }
  
    public function website()
    {
        $hash=new Hashids();
       
        $wisata = Wisata::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {
        $query->get();}])->get();
        $kuliner = Kuliner::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {
        $query->get();}])->get();
        $akomodasi = Akomodasi::where('active', 1)->with(['kecamatan', 'media' => function ($query) {$query->get();}])->get();
            $baseUrl = "https://graph.instagram.com/me/media?";

            $instagramToken = InstagramToken::select('access_token')->latest()->first();
    
            // dd($instagramToken);
    
            $accessToken = env('INSTAGRAM_TOKEN');
    
            if ($instagramToken != null) {
                $accessToken = $instagramToken->access_token;
            }
    
            $params = array(
                'fields' => implode(',', array('id', 'caption', 'permalink', 'media_url', 'media_type', 'thumbnail_url', 'is_shared_to_feed', 'username', 'timestamp')),
                'access_token' => $accessToken,
                'limit' => 20
            );
    
            $url = $baseUrl . http_build_query($params);
            $result = $this->makeCurlRequest($url);
            $baner = Baner::all();
    
        return view('website.website',compact('baner','wisata','hash','kuliner','akomodasi'), [
            'mediaData' => $result['data'],
            'paging' => $result['paging']
        ]);
    }

   

        public function showdetailwisata($wisata)
    {
        $hash = new Hashids();
        $wisataId = $hash->decodeHex($wisata);
        $wisata = Wisata::find($wisataId);

        // Peningkatan jumlah views setelah mengambil data wisata
        event(new WisataViewEvent($wisata));

        $hargatiket = $wisata->hargatiket;
        $wisata->load('fasilitas', 'created_by');
        $latitude = $wisata->latitude;
        $longitude = $wisata->longitude;
        $weatherData = $this->getWeatherData($latitude, $longitude);
        $weatherCode = $weatherData['weather'][0]['icon']; // Ambil kode cuaca dari data yang diterima
        $imageName = $this->chooseWeatherImage($weatherCode);
        $temperatureKelvin = $weatherData['main']['temp'];
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $windSpeedMeterPerSecond = $weatherData['wind']['speed'];
        $windSpeedKilometerPerHour = $windSpeedMeterPerSecond * 3.6; // 1 meter/detik = 3.6 kilometer/jam
        $windSpeedMeterPerSecond = $windSpeedKilometerPerHour * 0.27777777778;
        $windSpeedMeterPerSecond = number_format($windSpeedMeterPerSecond, 2);

        return view('website.webdetailwisata', compact('wisata', 'hargatiket', 'hash', 'weatherData', 'imageName', 'temperatureCelsius','windSpeedMeterPerSecond'));
    }

  
   



    public function destinasi()
    {
        $hash=new Hashids();
       
        $wisata = Wisata::where('active', 1)->with(['getCategory', 'kecamatan', 'media' => function ($query) {
        $query->get();}])->get();
        
        $baner = Baner::all();
    
        return view('website.destinasi',compact('baner','wisata','hash'));
    }

   
 
}
