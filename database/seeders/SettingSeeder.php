<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            'id' => 1,
            'api_key' => '',
            'website_name' => 'The Vanguard Academy',
            'website_favicon' => 'favicon.ico',
            'company_logo' => 'logo.png',
            'company_favicon' => '',
            'company_name' => 'The Vanguard Academy',
            'company_about' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'company_address' => '907-909 Antel Global Corporate, Brgy. San Antonio, Pasig City, Metro Manila',
            'google_map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.2714876990763!2d121.05972724792107!3d14.583599997065233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c869d9acf3bd%3A0x3d08a34bc750b469!2sWebFocus%20Solutions%2C%20Inc.!5e0!3m2!1sen!2sph!4v1568093056927!5m2!1sen!2sph',
            'google_recaptcha_sitekey' => '6Lfgj7cUAAAAAJfCgUcLg4pjlAOddrmRPt86tkQK',
            'google_recaptcha_secret' => '6Lfgj7cUAAAAALOaFTbSFgCXpJldFkG8nFET9eRx',
            'data_privacy_title' => 'Privacy-Policy',
            'data_privacy_popup_content' => 'This website uses cookies to ensure you get the best experience.',
            'data_privacy_content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
            'mobile_no' => '09123456789',
            'fax_no' => '13232107114',
            'tel_no' => '(044) 795-1234',
            'email' => 'support@webfocus.ph',
            'social_media_accounts' => '',
            'copyright' => '2020-2021',
            'user_id' => '1',

        ];

        DB::table('settings')->insert($setting);
    }
}
