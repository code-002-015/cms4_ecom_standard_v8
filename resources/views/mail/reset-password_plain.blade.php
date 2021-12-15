Dear {{ $user->name }},

We have received a request to reset your password for your account in {{ $setting->company_name }} ({{ url('/') }})

{{ route('password.reset', $token) }}?email={{ $user->email }}

Please note that this password reset link is valid for one (1) hour.


If you did not request a password reset, please ignore this email or communicate with us if you have questions.
For any inquiry or comments, please contact us at {{ $setting->email }}. Thank you.


Regards,
{{ $setting->company_name }}



{{ $setting->company_name }}
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
