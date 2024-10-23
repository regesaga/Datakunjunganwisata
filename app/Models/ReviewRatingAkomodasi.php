<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRatingAkomodasi extends Model
{
    use HasFactory;

    protected $table = 'review_ratingsakomodasi';

    protected $fillable = [
        'wisatawan_id',
        'akomodasi_id',
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
    public function akomodasi()
    {
        return $this->belongsTo(Akomodasi::class, 'akomodasi_id', 'id');
    }
}