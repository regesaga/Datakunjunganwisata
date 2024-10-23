<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    public $table = 'fasilitas';
    
    protected $fillable = ['fasilitas_name'];

    public function wisata()
    {
        return $this->belongsToMany(Wisata::class);
    }

    public function akomodasi()
    {
        return $this->belongsToMany(Akomodasi::class);
    }




}
