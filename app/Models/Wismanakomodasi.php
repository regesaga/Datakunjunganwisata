<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wismanakomodasi extends Model
{
    use HasFactory;
    public $table = 'wismanakomodasi';
    protected $fillable = [
        'akomodasi_id',
        'tanggal_kunjungan',
        'wismannegara_id', 
        'jml_wisman_laki', 
        'jml_wisman_perempuan'
    ];

    public function akomodasi()
    {
        return $this->belongsTo(Akomodasi::class, 'akomodasi_id');
    }
    public function KelompokKunjungan()
    {
        return $this->belongsToMany(KelompokKunjungan::class);
    }
    
 

    // Di model Wismanakomodasi
public function wismanNegara()
{
    return $this->belongsToMany(WismanNegara::class, 'wisman_negara_wisman_akomodasi', 'wisman_akomodasi_id', 'wismannegara_id');
}

public static function getKunjunganPerYear($tahun)
    {
        return self::whereYear('tanggal_kunjungan', $tahun)->get();
    }
    
}