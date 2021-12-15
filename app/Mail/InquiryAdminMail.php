<?php

namespace App\Mail;

use App\Helpers\Webfocus\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquiryAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $clientInfo;
    public $adminInfo;

    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $clientInfo
     * @param $adminInfo
     */
    public function __construct($setting, $clientInfo, $adminInfo)
    {
        $this->setting = $setting;
        $this->clientInfo = $clientInfo;
        $this->adminInfo = $adminInfo;
    }

    /**
     * pwede
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.inquiry-admin')
            ->text('mail.inquiry-admin_plain')
            ->subject('Receive an Inquiry');
    }
}
