@component('mail::message')
<h3> Hello,</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	New Project has been assigned to you. Please find below details.
    </p>
	<h6>Company Name : {{$project->company->name}}</h6>
	<h6>Project Name : {{$project->name}}</h6>
	<h6>Project ID : {{$project->team_id}}</h6>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
