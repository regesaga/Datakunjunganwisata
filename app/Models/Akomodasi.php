<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Akomodasi extends Model implements HasMedia
{
    use HasFactory;
    

    protected $table = 'akomodasi';
    protected $appends = [
        'photos', 'thumbnail'
    ];

    use MultiTenantModelTrait, InteractsWithMedia;
    protected $fillable = 
    [
        'company_id',
        'namaakomodasi',
        'categoryakomodasi_id',
        'deskripsi',
        'alamat',
        'kecamatan_id',
        'instagram',
        'web',
        'telpon',
        'jambuka',
        'jamtutup',
        'kapasitas',
        'latitude',
        'active',
        'longitude',
        'created_by_id',
        
    ];
    public function reviews()
    {
        return $this->hasMany(ReviewRatingAkomodasi::class, 'akomodasi_id', 'id');
    }
    public function room()
    {
        return $this->hasMany(Rooms::class);
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class);
    }

  

    public function hargatiket()
    {
        return $this->hasMany(HargaTiket::class, 'akomodasi_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id', 'kecamatan_id');
    }

    public function getCategoryAkomodasi()
    {
        return $this->hasOne('App\Models\CategoryAkomodasi', 'id', 'categoryakomodasi_id');
    }

    public function categories()
    {
        return $this->hasOne('App\Models\CategoryAkomodasi');
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
        return $this->getFirstMediaUrl('photos');
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
                    $query->where('namaakomodasi', 'LIKE', "%$search%")
                        ->orWhere('deskripsi', 'LIKE', "%$search%")
                        ->orWhere('alamat', 'LIKE', "%$search%");
                });
            });
            
    }
    
    public function rekomendasiakomodasi()
    {
        return $this->hasOne(RekomendasiAkomodasi::class, 'akomodasi_id');
    }

    public function wisnuAkomodasi()
    {
        return $this->hasMany(WisnuAkomodasi::class, 'akomodasi_id');
    }

    public function wismanAkomodasi()
    {
        return $this->hasMany(WismanAkomodasi::class, 'akomodasi_id');
    }
}
