<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Wisatawan extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use HasFactory;


    protected  $table = 'wisatawan';
    protected $guarded = '';
    protected $primaryKey = 'id';
    protected $hidden = [
        'password',
    ];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'phone',
    //     'status',
    //     'created_at',
    //     'updated_at',
    // ];

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function pesantikets()
    {
        return $this->hasMany(Pesantiket::class);
    }

    public function pesankuliners()
    {
        return $this->hasMany(Pesankuliner::class);
    }

    public function reservs()
    {
        return $this->hasMany(Reserv::class);
    }

  
     // Relasi dengan ulasan wisata
public function reviewwisata()
{
    return $this->hasMany(ReviewRatingWisata::class, 'wisatawan_id', 'id');
}

// Relasi dengan ulasan kuliner
public function reviewkuliner()
{
    return $this->hasMany(ReviewRatingKuliner::class, 'wisatawan_id', 'id');
}

// Relasi dengan ulasan akomodasi
public function reviewakomodasi()
{
    return $this->hasMany(ReviewRatingAkomodasi::class, 'wisatawan_id', 'id');
}
     
   
}
