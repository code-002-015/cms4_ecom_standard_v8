<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

</head>
<title>Untitled Document</title>

<body>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            <img src="{{ Setting::get_company_logo_storage_path() }}" alt="company logo" width="175" />
        </div>

        <p style="margin-top: 30px;"><strong>Dear {{ $user->name }},</strong></p>

        <p>
            We have received a request to reset your password for your account in {{ $setting->company_name }} ({{ url('/') }})
        </p>

        <br />

        <div style="text-align: center;">
            <a href="{{ route('password.reset', $token) }}?email={{ $user->email }}" target="_blank" style="padding: 10px 20px; background: #0349fc; color: #fff;text-decoration: none;font-size: 14px; border-radius: 3px;">RESET MY PASSWORD</a>
        </div>

        <br />

        <p><strong>Please note that this password reset link is valid for one (1) hour.</strong></p>

        <br />

        <p>If you did not request a password reset, please ignore this email or communicate with us if you have questions.</p>

        <br />

        <p>For any inquiry or comments, please contact us at {{ $setting->email }}. Thank you.</p>

        <br />

        <br />

        <p>
            <strong>
                Regards, <br />
                {{ $setting->company_name }}
            </strong>
        </p>
    </div>

    <div style="padding: 30px;background: #fff;margin-top: 20px;border-top: solid 1px #eee;text-align: center;color: #aaa;">
        <p style="font-size: 12px;">
            <strong>{{ $setting->company_name }}</strong> <br /> {{ $setting->company_address }} <br /> {{ $setting->tel_no }} | {{ $setting->mobile_no }}

            <br /><br /> {{ url('/') }}
        </p>
    </div>
</div>

</body>

</html>
