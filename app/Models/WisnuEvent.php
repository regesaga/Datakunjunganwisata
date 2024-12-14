<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisnuEvent extends Model
{
    public $table = 'wisnu_event';
    use HasFactory;
    protected $fillable = [
        'event_calendar_id',
        'tanggal_kunjungan',
        'kelompok_kunjungan_id', 
        'jumlah_laki_laki', 
        'jumlah_perempuan'
    ];

    public function evencalender()
    {
        return $this->belongsTo(Evencalender::class, 'event_calendar_id');
    }

    public function kelompokkunjungan()
    {
        return $this->belongsTo(KelompokKunjungan::class, 'kelompok_kunjungan_id');
    }

    public static function getKunjunganPerMonthAndYear($tahun, $bulan)
    {
        return self::whereYear('tanggal_kunjungan', $tahun)
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->sum(DB::raw('jumlah_laki_laki + jumlah_perempuan'));
    }
}
