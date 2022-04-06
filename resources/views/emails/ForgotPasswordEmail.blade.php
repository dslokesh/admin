@component('mail::message')
<h3> Hello {{ $adminuser_details['name']}},</h3>
<p
    style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
    We've received a request to reset the password.
    </p>
<p
    style="margin:10px 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
    You can reset your password by clicking the button below:
</p>

<p style="text-align: center;">
    <a href="{{url('forgot-password', $adminuser_details['token'])}}">Reset your password</a>
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
