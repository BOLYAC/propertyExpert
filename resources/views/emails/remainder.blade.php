@component('mail::message')
# Remainder CRM
@isset($notifiable['events_count'])
### You have: {{ $notifiable['events_count'] }} appointments today.
@endisset
@isset($notifiable['tasks_count'])
### You have: {{ $notifiable['tasks_count'] }} Tasks today.
@endisset

@component('mail::button', ['url' => config('app.url') ])
Go to the crm
@endcomponent

This email is coming from {{ config('app.name') }}
@endcomponent
