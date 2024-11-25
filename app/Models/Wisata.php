<?php

namespace App\Models;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Wisata extends Model implements HasMedia
{protected $guarded = [];

    protected $table = 'wisatas';
    protected $appends = [
        'photos', 'thumbnail'
    ];

    use MultiTenantModelTrait, InteractsWithMedia;
    protected $fillable = 
    [
        
        'company_id',
        'namawisata',
        'categorywisata_id',
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
    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class);
    }

    public function reviews()
    {
        return $this->hasMany(ReviewRatingWisata::class, 'wisata_id', 'id');
    }
  

    public function hargatiket()
    {
        return $this->hasMany(HargaTiket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id', 'kecamatan_id');
    }

    public function getCategory()
    {
        return $this->hasOne('App\Models\CategoryWisata', 'id', 'categorywisata_id');
    }

    public function categories()
    {
        return $this->hasOne('App\Models\CategoryWisata');
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
                    $query->where('namawisata', 'LIKE', "%$search%")
                        ->orWhere('deskripsi', 'LIKE', "%$search%")
                        ->orWhere('alamat', 'LIKE', "%$search%");
                });
            });
            
    }

    public function rekomendasiwisata()
    {
        return $this->hasOne(RekomendasiWisata::class, 'wisata_id');
    }
    

    public function kunjunganwisata()
{
    return $this->hasMany(KunjunganWisata::class);
}



public function wisnuWisata()
    {
        return $this->hasMany(WisnuWisata::class, 'wisata_id');
    }

    public function wismanWisata()
    {
        return $this->hasMany(WismanWisata::class, 'wisata_id');
    }


}
