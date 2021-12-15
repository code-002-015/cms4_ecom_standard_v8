<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactUsEmailLayoutInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('contact_us_email_layout')->nullable();
        });

        $contactUsEmailContent = '<style>
                    body {
                        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                        background: #f0f0f0;
                    }
                
                    h1,
                    h2,
                    h3,
                    h4,
                    h5,
                    h6,
                    p {
                        margin: 10px 0;
                        padding: 0;
                        font-weight: normal;
                    }
                
                    p {
                        font-size: 13px;
                    }
                </style>
                
                <!-- BODY-->
                <div style="max-width: 700px; width: 100%; background: #fff;margin: 30px auto;">
                
                    <div style="padding:30px 60px;">
                        <div style="text-align: center;padding: 20px 0;">
                            {company_logo}
                        </div>
                
                        <p style="margin-top: 30px;"><strong>Dear {name},</strong></p>
                
                        <p>
                            This is to inform you that your inquiry has been sent to our Admin for action.
                        </p>
                
                        <p>
                            Please expect a response within 24 hours.
                        </p>
                
                        <p>
                            For your reference, please see details of your inquiry below.
                        </p>
                
                        <br />
                
                        <table style="width:100%; padding: 20px;background: #f0f0f0;font-size: 14px;">
                            <tbody>
                            <tr>
                                <td width="30%"><strong>Name</strong></td>
                                <td>{name}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{email}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact Number</strong></td>
                                <td>{contact}</td>
                            </tr>
                            <tr>
                                <td><strong>Message</strong></td>
                                <td>{message}</td>
                            </tr>
                            </tbody>
                        </table>
                
                        <br />
                
                        <br />
                
                        <p>
                            <strong>
                                Regards, 
                                <br />
                                {company_name}
                            </strong>
                        </p>
                    </div>
                
                    <div style="padding: 30px;background: #fff;margin-top: 20px;border-top: solid 1px #eee;text-align: center;color: #aaa;">
                        <p style="font-size: 12px;">
                            <strong>{company_name}</strong> 
                            <br /> 
                            {company_address}
                            <br /> 
                            {company_telephone_no} | {company_mobile_no}
                            <br />
                            <br /> 
                            {website_url}
                        </p>
                    </div>
                </div>';

        $settings = \App\Models\Setting::find(1);
        if (!empty($settings)) {
            $settings->update([
                'contact_us_email_layout' => $contactUsEmailContent
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
