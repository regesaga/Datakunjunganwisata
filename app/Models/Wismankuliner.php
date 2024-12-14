<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wismankuliner extends Model
{
    use HasFactory;
    public $table = 'wismankuliner';
    protected $fillable = [
        'kuliner_id',
        'tanggal_kunjungan',
        'wismannegara_id', 
        'jml_wisman_laki', 
        'jml_wisman_perempuan'
    ];

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id');
    }
    public function KelompokKunjungan()
    {
        return $this->belongsToMany(KelompokKunjungan::class);
    }
    
 

    // Di model Wismankuliner
public function wismanNegara()
{
    return $this->belongsToMany(WismanNegara::class, 'wisman_negara_wisman_kuliner', 'wisman_kuliner_id', 'wismannegara_id');
}
// Mengambil data kunjungan per bulan dan per tahun
public static function getKunjunganPerMonthAndYear($tahun, $bulan)
{
    return self::whereYear('tanggal_kunjungan', $tahun)
        ->whereMonth('tanggal_kunjungan', $bulan)
        ->sum(DB::raw('jml_wisman_laki + jml_wisman_perempuan'));
}
}