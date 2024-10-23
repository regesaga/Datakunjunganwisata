<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketWisata extends Model  implements HasMedia
{
    use HasFactory, MultiTenantModelTrait, InteractsWithMedia;
            public $table = 'paketwisata';
        protected $fillable = [
            'company_id',
            'namapaketwisata',
            'kegiatan',
            'htm',
            'nohtm',
            'destinasiwisata',
            'telpon',
            'active',
            ];
            public function reviews()
            {
                return $this->hasMany(ReviewRatingPaketwisata::class, 'paketwisata_id', 'id');
            }
        

            public function htpaketwisata()
                {
                    return $this->hasMany(Htpaketwisata::class, 'paketwisata_id');
                }

            public function registerMediaConversions(Media $media = null): void
            {
                $this->addMediaConversion('thumb')->width(325)->height(210);
            }
        
            public function getPhotosAttribute()
            {
                $files = $this->getMedia('photos');
                $files->each(function ($item) {
                    $item->url = $item->getUrl();
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
                return $query->when(request()->filled('search'), function ($query) {
                    $query->where(function ($query) {
                        $search = request()->input('search');
                        $query->where('title', 'LIKE', "%$search%")
                            ->orWhere('deskripsi', 'LIKE', "%$search%")
                            ->orWhere('lokasi', 'LIKE', "%$search%");
                    });
                });
            }

            public function company()
    {
        return $this->belongsTo(Company::class);
    }

           
}
        