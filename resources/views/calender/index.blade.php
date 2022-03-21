@extends('layouts.vertical.master')
@section('title', 'Calendar')

@section('style_after')
    <!-- Calender css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
@endsection

@section('style')

@endsection

@section('script_after')
    <!-- Plugins JS start-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            var SITEURL = "{{ url('/') }}";
            // page is now ready, initialize the calendar...
            $('#full_calendar_events').fullCalendar({
                // put your options and callbacks here
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                selectHelper: true,
                events: [
                        @foreach($events as $event)
                    {
                        id: '{{ $event->id }}',
                        title: '{{ $event->lead_name ?? $event->name ?? ''}}',
                        start: '{{ $event->event_date }}',
                        color: '{{ $event->color }}'
                    },
                    @endforeach
                ],
                eventClick: function (event) {
                    $.ajax({
                        type: "GET",
                        url: SITEURL + '/calendar-crud-ajax',
                        data: {
                            id: event.id,
                            type: 'show'
                        },
                        success: function (response) {
                            $('#event-detail').html(response);
                            displayMessage('Appointment found');
                        }
                    });
                }
            })
        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Calendar') }}</li>
@endsection

@section('breadcrumb-title')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="calendar-wrap">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Calender</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6 xl-40 col-lg-12 col-md-5 box-col-4">
                                    <div id='full_calendar_events'></div>
                                </div>
                                <div class="col-xl-6 xl-60 col-lg-12 col-md-7 box-col-8" id="event-detail">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

