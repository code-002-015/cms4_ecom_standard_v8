Dear {{ $user->name }},

You have successfully reset your password.
Please be reminded to always secure your password to prevent any unauthorized access.

For any inquiry or comments, please contact us at {{ $setting->email }}. Thank you.


Regards,
{{ $setting->company_name }}



{{ $setting->company_name }}
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
