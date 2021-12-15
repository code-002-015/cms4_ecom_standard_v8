<?php

namespace App\Mail;

use App\Helpers\Webfocus\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShareNewsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $news;
    public $emailFrom;
    public $senderName;
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $news
     * @param $emailFrom
     * @param $senderName
     * @param $recipientName
     */
    public function __construct($setting, $news, $emailFrom, $senderName, $recipientName)
    {
        $this->setting = $setting;
        $this->news = $news;
        $this->emailFrom = $emailFrom;
        $this->senderName = $senderName;
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->emailFrom)
            ->view('mail.share-news')
            ->text('mail.share-news_plain')
            ->subject($this->senderName.' has shared a news article to you');
    }
}
