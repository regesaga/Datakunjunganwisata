<?php
namespace App\Http\Controllers;
use App\Events\WisataViewEvent;
use App\Models\Wisata;
use App\Models\User;
use App\Models\HargaTiket;
use App\Models\ReviewRatingWisata;
use App\Models\Kecamatan;
use App\Models\Fasilitas;
use App\Models\CategoryWisata;
use App\Models\Baner;
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


class DestinasiController extends Controller
{

   

    public function index()
    {
        return view('Home');
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
        
        $fasilitas = Fasilitas::all();
        $wisatas = Wisata::where('active', 1)->with(['getCategory', 'kecamatan', 'media', 'hargatiket'])->get();
        $baner = Baner::all();
    
        return view('website.destinasi',compact('baner','wisatas','hash', 'fasilitas'));
    }



   
 
}
