<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokKunjungan extends Model
{
    use HasFactory;
    public $table = 'kelompokKunjungan';
    
    protected $fillable = ['kelompokkunjungan_name'];

 // One-to-many relationship with WisnuWisata
 public function wisnuwisata()
 {
     return $this->hasMany(WisnuWisata::class, 'kelompok_kunjungan_id');
 }

 // One-to-many relationship with WisnuKuliner
 public function wisnukuliner()
 {
     return $this->hasMany(WisnuKuliner::class, 'kelompok_kunjungan_id');
 }

 // One-to-many relationship with WisnuAkomodasi (add this if necessary)
 public function wisnuakomodasi()
 {
     return $this->hasMany(WisnuAkomodasi::class, 'kelompok_kunjungan_id');
 }

    

    
}
