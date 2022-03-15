@component('mail::message')
# A client have been assigned to you

This message is from CRM,
{{ $data['full_name'] }} has been assigned to you by {{ $data['assigned_by'] }}

@component('mail::button', [ 'url' => $data['link'] ])
    See the client
@endcomponent
<br>
{{ config('app.name') }}
@endcomponent
