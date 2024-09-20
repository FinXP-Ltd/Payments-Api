@component('mail::message')
![banner]

[banner]: {{ 'https://pweresources.blob.core.windows.net/images/email/banners/application.png' }} "Application"

# Verified Email Address

Dear User,

You successfully verified your email address. Please continue to create your account by clicking the button below.

@component('mail::button', ['url' => $data['link']])
Register
@endcomponent

If you have further questions, please contact us on operations@finxp.com

Regards,<br>
{{ config('mail.from.name') }}
@endcomponent

