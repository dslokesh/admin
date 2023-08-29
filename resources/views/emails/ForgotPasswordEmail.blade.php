@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Hello {{ $adminuser_details['name']}},</strong>
		</p>
		<p> We've received a request to reset the password.</p>
 
<p>You can reset your password by clicking the button below:</p>
 
<p style="text-align: center;">
    <a href="{{url('forgot-password', $adminuser_details['token'])}}">Reset your password</a>
</p>

<p><strong>Thanks</br></br>Team Abatera B2B </strong></p>
	</div>
@endsection

