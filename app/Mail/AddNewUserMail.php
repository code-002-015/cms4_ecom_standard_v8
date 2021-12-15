<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddNewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $user
     * @param $token
     */
    public function __construct($setting, $user, $token)
    {
        $this->setting = $setting;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.add-new-user')
            ->text('mail.add-new-user_plain')
            ->subject('Activate Your Account');
    }
}
