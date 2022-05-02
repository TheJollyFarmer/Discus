@component('mail::message')
# Howdy ho!

Before you can enjoy full unadulterated access to Discus you must confirm your email address.
We apologise for the inconvenience. You understand, right? Right? :)

@component('mail::button', ['url' => url('register/verify?token=' . $user->verification_token)])
I exist, probably...
@endcomponent

Regards,<br>
the {{ config('app.name') }} team.
@endcomponent
