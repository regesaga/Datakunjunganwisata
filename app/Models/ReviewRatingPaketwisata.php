<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRatingPaketwisata extends Model
{
    use HasFactory;

    protected $table = 'review_ratingspaketwisata';

    protected $fillable = [
        'wisatawan_id',
        'paketwisata_id',
        'comments',
        'star_rating',
        'status',
    ];

    // Relasi ke model Wisatawan
    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'wisatawan_id', 'id');
    }

    // Relasi ke Wisata
    public function paketwisata()
    {
        return $this->belongsTo(Paketwisata::class, 'paketwisata_id', 'id');
    }
}