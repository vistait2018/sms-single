@component('mail::message')
{{-- Logo at the top --}}
![{{ config('app.name') }}]({{$logoUrl}})

# Hello {{ $user->name }},

Your account has been activate. Welcome aboard!

**What you need to know**

- A temporary access Otp {{ $otp }}has been provided below. For security, please set a new password as soon as you sign in.
- This link will expire in  {{ $validity }}minutes.
- Do not share this link or your credentials with anyone.


**Location of request:** {{ $loginLocation }}

{{-- @component('mail::button', ['url' => $passwordResetUrl])
Reset Password
@endcomponent --}}

If you didn’t initiate this request, please contact our support team immediately.

Thanks,
{{ config('app.name') }}
@endcomponent
