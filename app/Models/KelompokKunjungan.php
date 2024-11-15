<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokKunjungan extends Model
{
    use HasFactory;
    public $table = 'kelompokKunjungan';
    
    protected $fillable = ['kelompokkunjungan_name'];

    public function wisnuwisata()
    {
        return $this->belongsToMany(WisnuWisata::class);
    }

    public function wisnukuliner()
    {
        return $this->belongsToMany(WisnuKuliner::class);
    }

    
}
