<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class Baner extends Model
{
    use HasFactory, MultiTenantModelTrait;

    protected $table = 'banner';
    protected $fillable = ['id', 'sampul', 'judul', 'created_by_id'];

    // Mengubah metode untuk mendapatkan URL thumbnail dengan URL lengkap secara otomatis
    public function getThumbnailUrl()
    {
        // Menggunakan fungsi url() untuk menghasilkan URL lengkap secara otomatis
        return url('upload/banner/'.$this->sampul); // Sesuaikan dengan struktur penyimpanan file Anda
    }
}
