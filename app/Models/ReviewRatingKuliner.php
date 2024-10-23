<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRatingKuliner extends Model
{
    use HasFactory;

    protected $table = 'review_ratingskuliner';

    protected $fillable = [
        'wisatawan_id',
        'kuliner_id',
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
    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id', 'id');
    }
}