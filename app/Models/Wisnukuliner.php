<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wisnukuliner extends Model
{
    public $table = 'wisnukuliner';
    use HasFactory;
    protected $fillable = [
        'kuliner_id',
        'tanggal_kunjungan',
        'kelompok_kunjungan_id', 
        'jumlah_laki_laki', 
        'jumlah_perempuan'
    ];

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id');
    }

    public function kelompokkunjungan()
    {
        return $this->belongsTo(KelompokKunjungan::class, 'kelompok_kunjungan_id');
    }

}