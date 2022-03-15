@extends('layouts.vertical.master')
@section('title', 'Event report')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')

    <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
    <script>
        let table = $('#res-config').DataTable({
            @can('can-generate-report')
            dom: 'frtBip',
            buttons: [
                {
                    extend: 'excel',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: '',
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: '',
                },
                {
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: '',
                }
            ],
            @endcan
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">{{ __('Events list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Events report') }}</li>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <div class="card-header p-2 b-t-primary">
                        <a href="{{ route('generate.report', $val) }}"
                           class="btn btn-sm btn-outline-success pull-right">{{ __('Generate report') }}
                            <i class="fa fa-file"></i></a>
                    </div>
                    <div class="card-body">
                        <h1 class="title text-center mb-4">
                            @switch($val)
                                @case('today')
                                {{ __('Appointments Report') }}
                                {{ \Carbon\Carbon::today()->toDateString() }}
                                @break

                                @case('tomorrow')
                                {{ __('Appointments Schedule Report') }}
                                {{ \Carbon\Carbon::tomorrow()->toDateString() }}
                                @break
                            @endswitch
                        </h1>
                        <div class="order-history dt-ext table-responsive">
                            <table id="res-config"
                                   class="table task-list-table table-striped table-bordered nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Sales Representative') }}</th>
                                    <th>{{ __('CUSTOMER NAME') }}</th>
                                    <th>{{ __('Date & Time') }}</th>
                                    <th>{{ __('Nationality') }}</th>
                                    <th>{{ __('Language') }}</th>
                                    <th>{{ __('Customer’s Location') }}</th>
                                    <th>{{ __('Lead Owner’s Notes') }}</th>
                                    <th>{{ __('Made by') }}</th>
                                    @switch($val)
                                        @case('tomorrow')

                                        @break

                                        @default
                                        <th>{{ __('Results') }}</th>
                                        <th>{{ __('Feedback') }}</th>
                                        <th>{{ __('Negativity') }}</th>
                                        @break
                                    @endswitch
                                    <th>{{ __('Previous Appointments Count') }}</th>
                                    <th>{{ __('Stage') }}</th>
                                    <th>{{ __('Lead Owner') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Confirmed') }}</th>
                                    <th>{{ __('Confirmed by') }}</th>
                                    <th>{{ __('Confirmation date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
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
                                                    echo __('None');
                                                    break;
                                                    case 1:
                                                    echo __('Under evaluation');
                                                    break;
                                                    case 2:
                                                    echo __('Postponed');
                                                    break;
                                                    case 3:
                                                    echo __('Negative');
                                                    break;
                                                    case 4:
                                                    echo __('Appointment not met');
                                                    break;
                                                    case 5:
                                                    echo __('Reservation');
                                                    break;
                                                    case 6:
                                                    echo __('Reservation Cancellation');
                                                    break;
                                                    case 7:
                                                    echo __('Sale');
                                                    break;
                                                    case 8:
                                                    echo __('Sale Cancellation');
                                                    break;
                                                    case 9:
                                                    echo __('After Sale');
                                                    break;
                                                    case 10:
                                                    echo __('Presentation');
                                                    break;
                                                    case 11:
                                                    echo __('Follow up');
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
                                                    echo __('None');
                                                    break;
                                                    case 2:
                                                    echo __('Low Budget');
                                                    break;
                                                    case 3:
                                                    echo __('Other Agencies');
                                                    break;
                                                    case 4:
                                                    echo __('Trust Issues');
                                                    break;
                                                    case 5:
                                                    echo __('Customer not interested');
                                                    break;
                                                    case 6:
                                                    echo __('Issues with projects');
                                                    break;
                                                    case 7:
                                                    echo __('Issues with payment plans');
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
                                                echo __('In contact');
                                                break;
                                                case 2:
                                                echo __('Appointment Set');
                                                break;
                                                case 3:
                                                echo __('Follow up');
                                                break;
                                                case 4:
                                                echo __('Reservation');
                                                break;
                                                case 5:
                                                echo __('contract signed');
                                                break;
                                                case 6:
                                                echo __('Down payment');
                                                break;
                                                case 7:
                                                echo __('Developer invoice');
                                                break;
                                                case 8:
                                                echo __('Won Deal');
                                                break;
                                                case 9:
                                                echo __('Lost');
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
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="col-lg-12 col-xl-6">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{__('Total records in this page:')}}</th>
                                        <td>{{ $events->count() }} {{ __('Record(s)') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Total appointments confirmed:')}}</th>
                                        <td>{{ $events->where('confirmed', '=', '1')->count() }} {{ __('Record(s)') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Total appointments Cencelled:')}}</th>
                                        <td>{{ $events->where('confirmed', '=', '0')->count() }} {{ __('Record(s)') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Report Generated by:') }}</th>
                                        <td>{{ auth()->user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Generated on:') }}</th>
                                        <td>{{ \Carbon\Carbon::now()->format('Y-m-d g:i a') }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
