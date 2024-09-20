@component('mail::message')

Hi {{ $user->first_name }},

Please resubmit the information and document needed.

Reasons:

<ol>
@foreach($reasons as $reason)
    <li>{{ str_replace('_', ' ', $reason) }}</li>
@endforeach
</ol>

Please visit again the application link that provided to you.

Thank you.

Regards,<br>
{{ config('app.name') }}

@endcomponent
