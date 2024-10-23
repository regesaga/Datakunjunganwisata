<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Htpaketwisata extends Model
{
    public $table = 'htpaketwisata';
    protected $fillable = ['paketwisata_id','jenis','harga'];

    use HasFactory;

    public function paketwisata()
    {
        return $this->belongsToMany(Paketwisata::class);
    }

}