<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaTiket extends Model
{


    public $table = 'harga_tikets';
    protected $fillable = ['wisata_id','kategori','harga'];

    use HasFactory;

    public function wisata()
    {
        return $this->belongsToMany(Wisata::class);
    }
    
    
   

 
}
