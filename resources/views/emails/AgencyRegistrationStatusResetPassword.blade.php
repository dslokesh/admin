@component('mail::message')
<h3> Hello {{$technician_details['name']}},</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	Greetings from Abaterab2b!<br>
    Here are the login details :-<br>
	Email: {{$technician_details['email']}}<br>
	Password: <b>{{$technician_details['password']}}</b>
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
