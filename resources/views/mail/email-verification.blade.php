@component('mail::message')
![banner]

[banner]: {{ 'https://pweresources.blob.core.windows.net/images/email/banners/application.png' }} "Application"

# Verify Email Address

Dear User,

Before being able to use your account you need to verify that this is your email address by clicking the button below.

@component('mail::button', ['url' => $data['link']])
Verify
@endcomponent

If you have further questions, please contact us on operations@finxp.com

Regards,<br>
{{ config('mail.from.name') }}
@endcomponent

