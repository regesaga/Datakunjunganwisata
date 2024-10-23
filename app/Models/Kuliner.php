<?php

namespace App\Models;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Kuliner extends Model implements HasMedia
{
    protected $table = 'kuliners';
    protected $appends = [
        'photos', 'thumbnail'
    ];

    use MultiTenantModelTrait, InteractsWithMedia;
    protected $fillable = 
    [
        'company_id',
        'categorykuliner_id',
        'namakuliner',
        'deskripsi',
        'alamat',
        'kecamatan_id',
        'instagram',
        'web',
        'telpon',
        'jambuka',
        'jamtutup',
        'latitude',
        'longitude',
        'active',
        'kapasitas',
        'created_by_id',
        'created_at',
        'updated_at'
        
    ];

    public function reviews()
    {
        return $this->hasMany(ReviewRatingKuliner::class, 'kuliner_id', 'id');
    }

    public function kulinerproduk()
    {
        return $this->hasMany(KulinerProduk::class);
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
                    $query->where('namakuliner', 'LIKE', "%$search%")
                        ->orWhere('deskripsi', 'LIKE', "%$search%")
                        ->orWhere('alamat', 'LIKE', "%$search%");
                });
            });
            
    }


    public function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id', 'kecamatan_id');
    }

    public function rekomendasikuliner()
    {
        return $this->hasOne(RekomendasiKuliner::class, 'kuliner_id');
    }

    public function getCategory()
    {
        return $this->hasOne('App\Models\CategoryKuliner', 'id', 'categorykuliner_id');
    }

    public function categories()
    {
        return $this->hasOne('App\Models\CategoryKuliner');
    }

}
