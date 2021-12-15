Dear {{ $adminInfo->firstname }},

{{ $clientInfo['name'] }} has sent an inquiry for your action.
Please see details of the inquiry below.

Subject: {{ $clientInfo['subject'] }}
Name: {{ $clientInfo['name'] }}
Email: {{ $clientInfo['email'] }}
Contact Number: {{ $clientInfo['contact'] }}
Message: {{ $clientInfo['message'] }}


Regards,
{{ $setting->company_name }}



{{ $setting->company_name }}
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
