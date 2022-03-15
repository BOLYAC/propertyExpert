@extends('layouts.vertical.master')
@section('title', 'Calendar')

@section('style_after')
    <!-- Calender css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fullcalendar.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fullcalendar.print.min.css') }}" media='print'>
    <!-- Plugins css start-->
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/calendar.css') }}">--}}
@endsection

@section('style')

@endsection

@section('script_after')
    <!-- Plugins JS start-->
        <script src="{{ asset('assets/js/calendar/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/calendar/fullcalendar.min.js') }}"></script>
{{--    <script src="{{ asset('assets/js/calendar/tui-code-snippet.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/tui-time-picker.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/tui-date-picker.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/moment.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/chance.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/tui-calendar.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/calendars.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/schedules.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/js/calendar/app.js') }}"></script>--}}

    <script>
        $(document).ready(function () {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                minTime: "06:00:00",
                maxTime: "22:00:00",
                defaultView: $(window).width() < 765 ? 'basicDay' : 'agendaWeek',
                events: [
                        @foreach($events as $event)
                    {
                        title: '{{ $event->lead_name  ?? $event->name ?? ''}}',
                        url: '{{ route('events.show', $event->id) }}',
                        start: '{{ $event->event_date }}',
                        color: '{{ $event->color }}'
                    },
                    @endforeach
                ],
                dayClick: function(date, allDay, jsEvent, view) {
                    let eventsCount = 0;
                    let date1 = date.format('YYYY-MM-DD');
                    $('#calendar').fullCalendar('clientEvents', function(event) {
                        let start = moment(event.start).format("YYYY-MM-DD");
                        let end = moment(event.end).format("YYYY-MM-DD");
                        if(date1 == start)
                        {
                            eventsCount++;
                        }
                    });
                    alert(eventsCount);
                }
            })
        })

    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Calendar') }}</li>
@endsection

@section('breadcrumb-title')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card box-shadow-title">
                    <div class="card-header">
                        <h5>{{ __('Calender') }} </h5>
                    </div>
                    <div class="d-flex">
                        <div id="right">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

