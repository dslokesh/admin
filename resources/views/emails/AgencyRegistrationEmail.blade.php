@component('mail::message')
<h3> Hello {{$technician_details['name']}},</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	You have successfully registered with us.<br>
    
    Here are the details :-<br>
	Name: {{$technician_details['name']}}<br>
	Email: {{$technician_details['email']}}<br>
	Agency: {{$technician_details['company']}}<br>
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
