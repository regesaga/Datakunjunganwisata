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
    
    public function wismannegara()
    {
        return $this->belongsToMany(WismanNegara::class);
    }

    
}