<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContributorAddPageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $approver;
    public $contributor;
    public $page;

    /**
     * Create a new message instance.
     *Pa
     * @param $setting
     * @param $approver
     * @param $contributor
     * @param $page
     */
    public function __construct($setting, $approver, $contributor, $page)
    {
        $this->setting = $setting;
        $this->approver = $approver;
        $this->contributor = $contributor;
        $this->page = $page;
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
            ->subject('For your approval - New Page has been added');
    }
}
