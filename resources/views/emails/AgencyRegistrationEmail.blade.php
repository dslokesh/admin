@component('mail::message')
<h3> Dear Travel Partner,</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	Greetings from Abaterab2b!<br>
    Thank you for signing up, we have received your registration request successfully.<br>
	Your Log in credentials will be sent to your email within 24 hours.For any further information or assistance please feel free to contact us.<br>
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
