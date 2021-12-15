Dear {{ $user->name }},

Welcome to {{ $setting->company_name }}

Please access the link below to set up your password and complete the activation process of your account.

{{ route('password.reset', $token) }}?email={{ $user->email }}&user=new

Thank you.


Regards,
{{ $setting->company_name }}



{{ $setting->company_name }}
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
