<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetKunjungan extends Model
{
    use HasFactory;

    public $table = 'target_kunjungan';
    protected $fillable = ['tahun', 'bulan', 'target_kunjungan_wisata'];

    // Menambahkan method untuk mendapatkan data per tahun
    public static function getTargetPerYear($tahun)
    {
        return self::where('tahun', $tahun)->get();
    }
}
