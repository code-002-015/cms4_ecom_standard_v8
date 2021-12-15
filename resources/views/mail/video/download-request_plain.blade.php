Hello {{ $request->name }},

We are pleased to inform you that your request has been approved.
Click on the link below to download the video.

{{ $link }}


To follow up on your inquiry, you may contact {{ $setting->website_name }} at {{ $setting->email }}. Thank you.

{{ $setting->company_name }}
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}


{{ url('/') }}
