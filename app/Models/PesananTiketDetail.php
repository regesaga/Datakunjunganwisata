<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananTiketDetail extends Model
{
    protected $guarded = [];
    protected $table = 'pesantiketdetail';
    protected $fillable = [
        'pesantiket_id', 'harga_tiket_id', 'kategori','harga', 'jumlah'
    ];

  
    public function hargatiket()
    {
        return $this->belongsTo(HargaTiket::class);
    }

    public function pesantiket()
    {
        return $this->belongsTo(Pesantiket::class);
    }
    
   
}
