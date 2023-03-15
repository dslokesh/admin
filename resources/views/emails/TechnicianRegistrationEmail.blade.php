@component('mail::message')
<h3> Hello,</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	New Technician Registered.
    </p>
	
	<p style="margin:10px 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
    Here are the details :-<br>
	Name: {{$technician_details['name']}} {{$technician_details['lname']}}<br>
	Email: {{$technician_details['email']}}<br>
	Company: {{$technician_details['company']}}<br>
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
