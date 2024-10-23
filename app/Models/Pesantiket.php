<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesantiket extends Model
{
    use HasFactory;

    protected $table = 'pesantiket';
    protected $fillable = [
        'wisatawan_id', 'kodetiket','wisata_id', 'totalHarga', 'statuspemakaian','metodepembayaran','tanggalkunjungan','snap_token','payment_status','number'
    ];

    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class);
    }

    public function pesananTiketDetails()
    {
        return $this->hasMany(PesananTiketDetail::class, 'pesantiket_id');
    }

    

    public function hargatiket()
    {
        return $this->belongsTo(HargaTiket::class, 'harga_tiket_id');
    }

    public function details()
    {
        return $this->hasMany(PesananTiketDetail::class);
    }

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }


    // const STATUS_PENDING = 0;
    // const STATUS_SUCCESS = 1;
    // const STATUS_EXPIRED = 2;
    // const STATUS_FAILED = 3;

    // /**
    //  * Set payment status to pending
    //  *
    //  * @return void
    //  */
    // public function setPending()
    // {
    //     $this->update(['payment_status' => self::STATUS_PENDING]);
    // }

    // /**
    //  * Set payment status to success
    //  *
    //  * @return void
    //  */
    // public function setSuccess()
    // {
    //     $this->update(['payment_status' => self::STATUS_SUCCESS]);
    // }

    // /**
    //  * Set payment status to expired
    //  *
    //  * @return void
    //  */
    // public function setExpired()
    // {
    //     $this->update(['payment_status' => self::STATUS_EXPIRED]);
    // }

    // /**
    //  * Set payment status to failed
    //  *
    //  * @return void
    //  */
    // public function setFailed()
    // {
    //     $this->update(['payment_status' => self::STATUS_FAILED]);
    // }

}
