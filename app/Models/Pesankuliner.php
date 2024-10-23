<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesankuliner extends Model
{
    use HasFactory;

    protected $table = 'pesankuliner';
    protected $fillable = [
        'wisatawan_id', 'kodepesanan','kuliner_id', 'totalHarga', 'statuspesanan','metodepembayaran','tanggalkunjungan','snap_token','payment_status','number'
    ];

    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class);
    }

    public function pesankulinerdetails()
    {
        return $this->hasMany(PesanKulinerDetail::class);
    }

    

    public function kulinerproduk()
    {
        return $this->belongsTo(KulinerProduk::class, 'kulinerproduk_id');
    }

    public function details()
    {
        return $this->hasMany(PesanKulinerDetail::class);
    }

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id');
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
