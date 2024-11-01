<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WismanNegara extends Model
{
    use HasFactory;

    public $table = 'wismannegara';
    protected $fillable = ['wismannegara_name'];


   


// Di model WismanNegara
public function wismanWisata()
{
    return $this->belongsToMany(WismanWisata::class, 'wisman_negara_wisman_wisata', 'wismannegara_id', 'wisman_wisata_id');
}




}
