<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamOperasional extends Model
{
    public $timestamps = false;

    public $table = 'jamoperasional';
    protected $primaryKey = 'id';
    protected $fillable = [
        'wisata_id',
        'hari', 
        'jam_buka',
        'jam_tutup'
    ];

    use HasFactory;

    public function tambah()
    {
        return $this->hasMany('App\Models\Wisata');
    }
    public function wisata()
    {
        return $this->hasMany('App\Models\Wisata', 'id');
    }

    public function pencari()
    {
        return $this->belongsTo('App\Models\Pencari', 'id');
    }


 
}
