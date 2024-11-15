<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wisnuakomodasi extends Model
{
    public $table = 'wisnuakomodasi';
    use HasFactory;
    protected $fillable = [
        'akomodasi_id',
        'tanggal_kunjungan',
        'kelompok_kunjungan_id', 
        'jumlah_laki_laki', 
        'jumlah_perempuan'
    ];

    public function akomodasi()
    {
        return $this->belongsTo(Kuliner::class, 'akomodasi_id');
    }

    public function kelompokkunjungan()
    {
        return $this->belongsTo(KelompokKunjungan::class, 'kelompok_kunjungan_id');
    }

}
