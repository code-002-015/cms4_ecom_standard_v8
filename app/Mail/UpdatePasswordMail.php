<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($setting, $user)
    {
        $this->setting = $setting;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.password-success')
                    ->text('mail.password-success_plain')
                    ->subject('Password Reset Successful');
    }
}
