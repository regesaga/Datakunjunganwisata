<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SektorEkraf extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public $table = 'sektorekraf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sektor_name',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
