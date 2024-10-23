<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Company extends Model
{
    protected $table = 'companies';
    use HasFactory;
    protected $fillable = ['user_id','nama', 'title', 'ijin', 'phone'];

    
    public function wisata()
    {
        return $this->hasOne(Wisata::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function akomodasi()
    {
        return $this->hasOne(Akomodasi::class);
    }

    public function kuliner()
    {
        return $this->hasOne(Kuliner::class);
    }

    public function ekraf()
    {
        return $this->hasOne(Ekraf::class);
    }

    public function paketwisata()
    {
        return $this->hasMany(PaketWisata::class);
    }


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
