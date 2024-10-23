<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiKuliner extends Model
{
    use HasFactory;
    protected $table = 'rekomendasikuliner';
    protected $fillable = ['kuliner_id'];
    
    
    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id');
    }
}
