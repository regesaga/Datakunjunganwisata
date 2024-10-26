<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganWisata extends Model
{
    use HasFactory;
    protected $table = 'kunjunganwisata'; // Nama tabel

    protected $fillable = [
        'wisata_id',
        'tanggal_kunjungan',
        'wisnu_umum_laki',
        'wisnu_umum_perempuan',
        'wisnu_pelajar_laki',
        'wisnu_pelajar_perempuan',
        'wisnu_instansi_laki',
        'wisnu_instansi_perempuan',
        'jml_wisnu_perempuan',
        'jml_wisnu_laki',
        'total_wisnu',
        'wisman_negara',
        'wisman_laki',
        'wisman_perempuan',
        'jml_wisman_laki',
        'jml_wisman_perempuan',
        'total_wisman',

    ];

    /**
     * Relasi dengan model Wisata.
     * Satu kunjungan berkaitan dengan satu wisata.
     */
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }
}
