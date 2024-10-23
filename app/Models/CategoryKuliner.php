<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryKuliner extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public $table = 'categorykuliner';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


   
}
