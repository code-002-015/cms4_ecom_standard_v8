<?php

namespace App\Mail;

use App\Helpers\Webfocus\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $clientInfo;
    public $emailContent;
    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $clientInfo
     */
    public function __construct($setting, $clientInfo)
    {
        $this->setting = $setting;
        $this->clientInfo = $clientInfo;
        $this->emailContent = $setting->contact_us_email_layout;
    }

    /**
     * pwede
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $companyLogo = '<img src="' .Setting::get_company_logo_storage_path(). '" alt="company logo" width="175" />';
        $this->emailContent = str_replace('{company_logo}', $companyLogo, $this->emailContent);
        $this->emailContent = str_replace('{name}', $this->clientInfo['name'], $this->emailContent);
        $this->emailContent = str_replace('{email}', $this->clientInfo['email'], $this->emailContent);
        $this->emailContent = str_replace('{contact}', $this->clientInfo['contact'], $this->emailContent);
        $this->emailContent = str_replace('{subject}', $this->clientInfo['subject'], $this->emailContent);
        $this->emailContent = str_replace('{message}', $this->clientInfo['message'], $this->emailContent);
        $this->emailContent = str_replace('{company_name}', $this->setting->company_name, $this->emailContent);
        $this->emailContent = str_replace('{company_address}', $this->setting->company_address, $this->emailContent);
        $this->emailContent = str_replace('{company_telephone_no}', $this->setting->tel_no, $this->emailContent);
        $this->emailContent = str_replace('{company_mobile_no}', $this->setting->mobile_no, $this->emailContent);
        $this->emailContent = str_replace('{website_url}', url('/'), $this->emailContent);

        return $this->view('mail.inquiry')
            ->subject('Inquiry Received');
        // ->text('mail.inquiry_plain')
    }
}
