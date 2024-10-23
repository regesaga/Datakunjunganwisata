<?php

namespace App\Models;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Rooms extends Model implements HasMedia
{
    protected $guarded = [];

    protected $table = 'rooms';
    protected $appends = [
        'photos', 'thumbnail'
    ];

    use MultiTenantModelTrait, InteractsWithMedia;
    protected $fillable = 
    [
        
        'nama',
        'categoryroom_id',
        'akomodasi_id',
        'deskripsi',
        'harga',
        'kapasitas',
        'active',
        'created_by_id',
        
    ];

    public function akomodasi()
    {
        return $this->belongsTo(Akomodasi::class);
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class);
    }

  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

   
    public function getCategory()
    {
        return $this->hasOne('App\Models\CategoryRooms', 'id', 'categoryroom_id');
    }

    public function categories()
    {
        return $this->hasOne('App\Models\CategoryRooms');
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

