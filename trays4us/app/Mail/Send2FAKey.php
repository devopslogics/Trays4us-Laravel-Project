<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Send2FAKey extends Mailable
{
    use Queueable, SerializesModels;

    public $twoFaKey;

    public function __construct($twoFaKey)
    {
        $this->twoFaKey = $twoFaKey;
    }

    public function build()
    {
        return $this->view('emails.2fa-key')
            ->subject('Your 2FA Key')
            ->with(['twoFaKey' => $this->twoFaKey]);
    }
}
