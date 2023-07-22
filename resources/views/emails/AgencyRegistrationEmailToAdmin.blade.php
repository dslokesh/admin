@component('mail::message')
<h3> Hello,</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	New Agency Registered.<br>
    
    Here are the details :-<br>
	Agent Name: {{$technician_details['name']}}<br>
	Email: {{$technician_details['email']}}<br>
	Agency: {{$technician_details['company']}}<br>
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
