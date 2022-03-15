@component('mail::message')
# An appointment have been set

## Title: {{ $data['title'] }}

### Made by: {{ $data['user'] }}
### For the client: {{ $data['client'] }}

@component('mail::panel')
Date of appointment: {{ $data['date'] }}
Place: {{ $data['place'] }}
@endcomponent

{!! $data['description'] !!}

@component('mail::button', ['url' => $data['link'] ])
Show the appointment on the CRM
@endcomponent

This email is coming from {{ config('app.name') }}
@endcomponent
