<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRooms extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public $table = 'categoryroom';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'category_name',
        'created_at',
        'updated_at',
    ];

   
}
