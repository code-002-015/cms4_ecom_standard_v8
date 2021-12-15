<?php

namespace App\Mail;

use App\Helpers\Webfocus\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $clientInfo
     */
    public function __construct($setting)
    {
        $this->setting = $setting;
    }

    /**
     * pwede
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.application-mail')
            ->subject('Job Application Received');
    }
}
