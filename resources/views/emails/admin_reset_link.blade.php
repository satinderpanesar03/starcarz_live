<x-mail::message>
Dear User,

Please click on below button to change your account password.


<x-mail::button :url="$body['link']">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
