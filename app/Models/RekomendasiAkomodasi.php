<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiAkomodasi extends Model
{
    use HasFactory;
    protected $table = 'rekomendasiakomodasi';
    protected $fillable = ['akomodasi_id'];
    
    
    public function akomodasi()
    {
        return $this->belongsTo(Akomodasi::class, 'akomodasi_id');
    }
}
