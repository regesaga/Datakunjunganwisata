<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WismanWisata extends Model
{
    use HasFactory;
    public $table = 'wismanwisata';
    protected $fillable = [
        'wisata_id',
        'tanggal_kunjungan',
        'wismannegara_id', 
        'jml_wisman_laki', 
        'jml_wisman_perempuan'
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }
    public function KelompokKunjungan()
    {
        return $this->belongsToMany(KelompokKunjungan::class);
    }
    
 

    // Di model WismanWisata
public function wismanNegara()
{
    return $this->belongsToMany(WismanNegara::class, 'wisman_negara_wisman_wisata', 'wisman_wisata_id', 'wismannegara_id');
}

// Mengambil data kunjungan per bulan dan per tahun
public static function getKunjunganPerMonthAndYear($tahun, $bulan)
{
    return self::whereYear('tanggal_kunjungan', $tahun)
        ->whereMonth('tanggal_kunjungan', $bulan)
        ->sum(DB::raw('jml_wisman_laki + jml_wisman_perempuan'));
}


    
}
