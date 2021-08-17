@component('mail::message')
#introduction

The body of your message
<h2>{{$details['title']}}</h2>

@component('mail::panel')
{{$details['body']}}
@endcomponent

@component('mail::button', ['url' => ''])
    Button Text
@endcomponent


Thanks,<br>
{{ config('app.name') }}

@endcomponent