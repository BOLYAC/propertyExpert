@component('mail::message')

### This message is from CRM,

# A client(s) have been assigned to you by {{ $data[0]['assigned_by'] }}

@foreach($data as $k => $v)

#### [{{ $v['full_name'] }}]({{ $v['link'] }})

@endforeach

@component('mail::button', [ 'url' => route('clients.index') ])
See all Clients
@endcomponent

<br>
{{ config('app.name') }}

@endcomponent
