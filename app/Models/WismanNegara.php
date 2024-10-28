<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WismanNegara extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $table = 'wismannegara';
    protected $primaryKey = 'id';
    protected $fillable = [
        'wismannegara_name',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function wismanwisata()
    {
        return $this->belongsToMany(WismanWisata::class);
    }
}
