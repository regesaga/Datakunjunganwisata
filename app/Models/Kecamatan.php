<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    public function wisatas()
    {
        return $this->hasMany('App\Models\Wisata');
    }
    public $table = 'Kecamatan';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'Kecamatan'
    ];



    public function kuliners()
    {
        return $this->hasMany('App\Models\Kuliner');
    }
}
