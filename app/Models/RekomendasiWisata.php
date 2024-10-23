<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiWisata extends Model
{
    use HasFactory;
    protected $table = 'rekomendasiwisata';
    protected $fillable = ['wisata_id'];
    
    
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }
}
