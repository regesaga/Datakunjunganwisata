<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BanerPromo extends Model implements HasMedia
{
    use HasFactory, MultiTenantModelTrait, InteractsWithMedia;
    protected $table = 'banerpromo';
    protected $fillable = ['sampul', 'judul','active', 'created_by_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
