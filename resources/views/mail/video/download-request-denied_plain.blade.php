Dear {{ $request->name }},

Please be informed that your video request sent last {{ date('M d, Y h:i A', strtotime($request->created_at)) }} has been denied.
Apologies for the inconvenience this has caused you.

If you have questions, please feel free to contact us thru {{ $setting->email }}.


Regards,
{{ $setting->company_name }}



{{ $setting->company_name }}
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
