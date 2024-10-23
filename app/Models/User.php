<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

use Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    use HasApiTokens;
    use TwoFactorAuthenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'users';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
  
     public function banerpromo()
     {
         return $this->hasMany(BanerPromo::class, 'created_by_id');
     }
   
    public function article()
    {
        return $this->hasMany(Article::class, 'created_by_id');
    }

    public function wisatas()
    {
        return $this->hasMany(Wisata::class, 'created_by_id', 'id');
    }

    public function kuliners()
    {
        return $this->hasMany(Kuliner::class, 'created_by_id', 'id');
    }


    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
   {
       return $this->roles->contains('name', $role);
   }


    

   
    

  

}
