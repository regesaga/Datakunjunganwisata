<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRatingWisata extends Model
{
    use HasFactory;

    protected $table = 'review_ratingswisata';

    protected $fillable = [
        'wisatawan_id',
        'wisata_id',
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
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id', 'id');
    }
}