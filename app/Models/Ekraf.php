<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ekraf extends Model implements HasMedia
{
    use HasFactory;
            
            use MultiTenantModelTrait, InteractsWithMedia;
            public $table = 'ekraf';
            protected $fillable = 
            [
                'id',
                'company_id',
                'namaekraf',
                'sektorekraf_id',
                'deskripsi',
                'alamat',
                'kecamatan_id',
                'instagram',
                'web',
                'telpon',
                'latitude',
        'active',
        'longitude',
        'created_by_id',
            ];
        
            
           
        
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
                            $query->where('namaekraf', 'LIKE', "%$search%")
                                ->orWhere('deskripsi', 'LIKE', "%$search%")
                                ->orWhere('alamat', 'LIKE', "%$search%");
                        });
                    });
                    
            }
        
        
            public function kecamatan()
            {
                return $this->hasOne('App\Models\Kecamatan', 'id', 'kecamatan_id');
            }

            public function getSektor()
            {
                return $this->hasOne('App\Models\SektorEkraf', 'id', 'sektorekraf_id');
            }

            public function company()
            {
                return $this->belongsTo(Company::class);
            }
        
        }
        