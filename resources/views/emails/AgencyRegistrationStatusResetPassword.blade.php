@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Dear {{$technician_details['name']}},</strong>
		</p>
		<p>Greetings from Abaterab2b!</p>
 
<p>Here are the login details</p>
 
<p>Email: {{$technician_details['email']}}<br>
	Password: <b>{{$technician_details['password']}}</b></p>


 
<p><strong>Thanks</br></br>Team Abatera B2B </strong></p>
	</div>


@endsection
