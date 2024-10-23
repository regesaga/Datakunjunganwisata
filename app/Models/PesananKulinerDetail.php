<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananKulinerDetail extends Model
{
    protected $guarded = [];
    protected $table = 'pesankulinerdetail';
    protected $fillable = [
        'pesankuliner_id', 'kulinerproduk_id', 'nama','harga', 'jumlah'
    ];

  
    public function kulinerproduk()
    {
        return $this->belongsTo(KulinerProduk::class);
    }

   
}
