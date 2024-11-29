<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Evencalender extends Model implements HasMedia
{
    use HasFactory, MultiTenantModelTrait, InteractsWithMedia;

    protected $table = 'event_calendar';
    protected $appends = [
        'photos', 'thumbnail'
    ];
    protected $fillable = [
        'title',
        'deskripsi',
        'jammulai',
        'jamselesai',
        'lokasi',
        'active',
        'latitude',
        'longitude',
        'created_by_id',
        'tanggalmulai',
        'tanggalselesai',
    ];

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




    public function wisnuEvent()
    {
        return $this->hasMany(WisnuEvent::class, 'event_calendar_id');
    }

    public function wismanEvent()
    {
        return $this->hasMany(WismanEvent::class, 'event_calendar_id');
    }


}
