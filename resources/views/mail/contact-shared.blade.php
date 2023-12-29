<x-mail::message>
# New contact shared with you

  User <span class='text-info'>{{ $fromUser }}</span> shared contact <span class='text-info'>{{$sharedContact}}</span> with you
<x-mail::button :url="route('contact-shares.index')">
See here</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
