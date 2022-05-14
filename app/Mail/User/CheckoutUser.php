<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pCart, $cCart, $user)
    {
        $this->pcart = $pCart;
        $this->ccart = $cCart;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->subject("Menunggu Pembayaran Pesanan Anda")
        ->markdown('mail.user.checkout')
        ->with(
            [
                'packages' => $this->pcart,
                'campinggears' => $this->ccart,
                'user' => $this->user,
            ]
        );

    }
}
