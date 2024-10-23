<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class KulinerProduk extends Model implements HasMedia
{
    protected $guarded = [];

    protected $table = 'kulinerproduk';
    protected $appends = [
        'photos', 'thumbnail'
    ];
    use HasFactory;
    use MultiTenantModelTrait, InteractsWithMedia;
    protected $fillable = 
    [
        
        'nama',
        'kuliner_id',
        'deskripsi',
        'harga',
        'active',
        
    ];

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class);
    }

  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

   
    
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(325)->height(210);
    }

       
    public function getPhotosAttribute()
    {
        $files = $this->getMedia('photos');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
        });

        return $files;
    }

    public function getThumbnailAttribute()
    {
        return $this->getFirstMediaUrl('photos', 'thumb');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function scopeSearchResults($query)
    {
        return $query->when(request()->filled('search'), function($query) {
                $query->where(function($query) {
                    $search = request()->input('search');
                    $query->where('nama', 'LIKE', "%$search%")
                        ->orWhere('deskripsi', 'LIKE', "%$search%");
                });
            });
            
    }

}
