<?php

namespace App\Mail\Wisatawan;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $wisatawan;
    public function __construct($wisatawan)
    {
        $this->wisatawan = $wisatawan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Permintaan Lupa Password')->view('wisatawan.auth.email-forgot-password'); // approve
    }
}
