<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Support extends Model implements HasMedia
{
    
    use HasFactory, MultiTenantModelTrait, InteractsWithMedia;
    protected $table = 'support';
    protected $fillable = ['sampul', 'judul','created_by_id'];
}
