<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WismanEvent extends Model
{
    use HasFactory;
    public $table = 'wisman_event';
    protected $fillable = [
        'event_calendar_id',
        'tanggal_kunjungan',
        'wismannegara_id', 
        'jml_wisman_laki', 
        'jml_wisman_perempuan'
    ];

    public function evencalender()
    {
        return $this->belongsTo(Evencalender::class, 'event_calendar_id');
    }
    public function KelompokKunjungan()
    {
        return $this->belongsToMany(KelompokKunjungan::class);
    }
    
 

    // Di model Wismanakomodasi
public function wismanNegara()
{
    return $this->belongsToMany(WismanNegara::class, 'wisman_negara_wisman_event', 'wisman_akomodasi_id', 'wismannegara_id');
}
}
