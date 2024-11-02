<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisnuWisata extends Model
{
    public $table = 'wisnuwisata';
    use HasFactory;
    protected $fillable = [
        'wisata_id',
        'tanggal_kunjungan',
        'kelompok_kunjungan_id', 
        'jumlah_laki_laki', 
        'jumlah_perempuan'
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }

    public function kelompokkunjungan()
    {
        return $this->belongsTo(KelompokKunjungan::class, 'kelompok_kunjungan_id');
    }

}

