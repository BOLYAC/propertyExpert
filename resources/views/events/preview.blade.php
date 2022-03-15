<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('Event report') }}</title>

    <style>

        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        .invoice-box {
            max-width: 100%;
            margin: 10px;
            padding: 10px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<h1> Appointments Schedule Report
    @switch($val)
        @case('today')
        {{ \Carbon\Carbon::today()->toDateString() }}
        @break

        @case('tomorrow')
        {{ \Carbon\Carbon::tomorrow()->toDateString() }}
        @break

        @case('custom')

        @break
    @endswitch
</h1>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{ __('Sales Representative') }}</td>
            <td>{{ __('CUSTOMER NAME') }}</td>
            <td>{{ __('Date & Time') }}</td>
            <td>{{ __('Nationality') }}</td>
            <td>{{ __('Language') }}</td>
            <td>{{ __('Customer’s Location') }}</td>
            <td>{{ __('Lead Owner’s Notes') }}</td>
            <td>{{ __('Made by') }}</td>
            @switch($val)
                @case('tomorrow')

                @break
                @default
                <th>Results</th>
                <th>Feedback</th>
                <th>Negativity</th>
                @break
            @endswitch
            <td>{{ __('Previous Appointments Count') }}</td>
            <td>{{ __('Stage') }}</td>
            <td>{{ __('Lead Owner') }}</td>
            <th>{{ __('Type') }}</th>
            <td>{{ __('Confirmed') }}</td>
            <td>{{ __('Confirmed By') }}</td>
            <td>{{ __('Conformation date') }}</td>
        </tr>
        @foreach($events as $key => $event)
            <tr>
                <td>
                    @php $sellRep = collect($event->sells_name)->toArray() @endphp
                    @foreach( $sellRep as $name)
                        <b>{{ $name }}</b><br>
                    @endforeach
                </td>
                <td>{{ $event->client->full_name ?? '' }}</td>
                <td>
                    {{ Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i') }}
                </td>
                <td>
                    @if(is_null($event->client->nationality))
                        {{ $event->client->getRawOriginal('nationality') ?? '' }}
                    @else
                        @php $countries = collect($event->client->nationality)->toArray() @endphp
                        @foreach( $countries as $name)
                            {{ $name }}
                        @endforeach
                    @endif
                </td>
                <td>
                    @if(is_null($event->client->lang))
                        {{ $event->client->getRawOriginal('lang') ?? '' }}
                    @else
                        @php $languages = collect($event->client->lang)->toArray() @endphp
                        @foreach( $languages as $name)
                            <b>{{ $name }}</b> <br>
                        @endforeach
                    @endif
                </td>
                <td>{{ $event->place }}</td>
                <td>
                    {!! $event->description !!}
                </td>
                <td>
                    {{ $event->user->name ?? '' }}
                </td>
                @switch($val)
                    @case('tomorrow')

                    @break
                    @default
                    <td>
                        @php
                            $i = $event->results;
                            switch ($i) {
                            case 0:
                            echo 'None';
                            break;
                            case 1:
                            echo 'Under evaluation';
                            break;
                            case 2:
                            echo 'Postponed';
                            break;
                            case 3:
                            echo 'Negative';
                            break;
                            case 4:
                            echo 'Appointment not met';
                            break;
                            case 5:
                            echo 'Reservation';
                            break;
                            case 6:
                            echo 'Reservation Cancellation';
                            break;
                            case 7:
                            echo 'Sale';
                            break;
                            case 8:
                            echo 'Sale Cancellation';
                            break;
                            case 9:
                            echo 'After Sale';
                            break;
                            case 10:
                            echo 'Presentation';
                            break;
                            case 11:
                            echo 'Follow up';
                            break;
                            }
                        @endphp
                    </td>
                    <td>
                        {!! $event->feedback ?? '' !!}
                    </td>
                    <td>
                        @php
                            $i = $event->Negativity;
                            switch ($i) {
                            case 1:
                            echo 'None';
                            break;
                            case 2:
                            echo 'Low Budget';
                            break;
                            case 3:
                            echo 'Other Agencies';
                            break;
                            case 4:
                            echo 'Trust Issues';
                            break;
                            case 5:
                            echo 'Customer not interested';
                            break;
                            case 6:
                            echo 'Issues with projects';
                            break;
                            case 7:
                            echo 'Issues with payment plans';
                            break;
                            }
                        @endphp
                    </td>
                    @break
                @endswitch

                <td>
                    @switch($val)
                        @case('tomorrow')
                        {{ $event->client->events->where('event_date', '<', Carbon\Carbon::tomorrow())->count() }}
                        @break
                        @default
                        {{ $event->client->events->where('event_date', '<', Carbon\Carbon::today())->count() }}
                        @break
                    @endswitch
                </td>
                <td>
                    @php
                        $i = $event->lead->status;
                        switch ($i) {
                        case 1:
                        echo 'In contact';
                        break;
                        case 2:
                        echo 'Appointment Set';
                        break;
                        case 3:
                        echo 'Follow up';
                        break;
                        case 4:
                        echo 'Reservation';
                        break;
                        case 5:
                        echo 'contract signed';
                        break;
                        case 6:
                        echo 'Down payment';
                        break;
                        case 7:
                        echo 'Developer invoice';
                        break;
                        case 8:
                        echo 'Won Deal';
                        break;
                        case 9:
                        echo 'Lost';
                        break;
                        }
                    @endphp
                </td>
                <td>
                    {{ $event->client->user->name ?? '' }}
                </td>
                <td>
                    {{ $event->zoom_meting === 1 ? 'Zoom' : 'Appointment' }}
                </td>
                <td>
                    {{ $event->confirmed === 1 ? 'Yes' : 'No' }}
                </td>
                <td>
                    {{ $event->confirmed_by ?? '' }}
                </td>
                <td>
                    {{ Carbon\Carbon::parse($event->confirmed_at)->format('Y-m-d H:i') }}
                </td>
            </tr>
        @endforeach
        <tr class="item last">
            <td>
                {{ __('Total records in this page:') }}
            </td>
            <td>
                {{ $events->count() }} Record(s)
            </td>
        </tr>
        <tr class="item last">
            <td>
                {{ __('Appointment confirmed:') }}
            </td>
            <td>
                {{ $confirmedEvents }} Record(s)
            </td>
        </tr>
        <tr class="item last">
            <td>
                {{ __('Appointment not confirmed:') }}
            </td>
            <td>
                {{ $notConfirmedEvents }} Record(s)
            </td>
        </tr>
        <tr class="total">
            <td>
                {{ __('Report Generated by:') }}
            </td>
            <td>
                {{ auth()->user()->name }}
            </td>
        </tr>
        <tr class="total">
            <td>
                {{ __('Generated on:') }}
            </td>
            <td>
                {{ \Carbon\Carbon::now()->format('Y-m-d g:i a') }}
            </td>
        </tr>
    </table>
</div>
<div>
</div>
</body>
