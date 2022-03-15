@extends('layouts.vertical.master')
@section('title', '| Appointment create')

@section('style_before')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
@endsection

@section('style')
    <style type="text/css">
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
@endsection

@section('script')
    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <script>
        $('.js-client-all').select2({
            ajax: {
                url: "{{ route('event.client.filter') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.full_name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $("#event_date").click(function () {
            var e = jQuery.Event("keydown");
            e.which = 115; // # Some key code value
            e.altKey = true;
            $("input#event_date").trigger(e);
        });
        $(document).ready(function () {
            $('#results').on('change', function () {
                if (this.value == '3') {
                    $("#negativity").show();
                } else {
                    $("#negativity").hide();
                }
            });
        });
        $('.js-language-all').select2({
            ajax: {
                url: "{{ route('language.name') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.name
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">{{ __('Appointments') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Appointment') }}</li>
@endsection

@section('breadcrumb-title')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col-6">
                                    <label for="name">{{ __('Title') }}</label>
                                    <input class="form-control sm" type="text" name="name" id="name"
                                           value="{{ old('name') }}">
                                </div>
                                <div class="form-group input-group-sm col-6">
                                    <label for="event_date">{{ __('Date of appointment') }}</label>
                                    <input name="event_date" id="event_date" class="form-control"
                                           value="{{ old('event_date') }}"
                                           type="datetime-local" required/>
                                </div>
                                <div class="form-group input-group-sm col-12">
                                    <label for="color">{{ __('Colors') }}</label>
                                    <div>
                                        <input id="color" name="color" value="#0B8043" type="color"
                                               list="presetColors">
                                        <datalist id="presetColors">
                                            <option>#0B8043</option>
                                            <option>#D50000</option>
                                            <option>#F4511E</option>
                                            <option>#8E24AA</option>
                                            <option>#3F51B5</option>
                                            <option selected>#039BE5</option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="form-group input-group-sm col-2">
                                    <label for="currency">{{ __('Currency') }}</label>
                                    <select class="form-control form-control-sm" id="currency" name="currency">
                                        <option value="try">TRY</option>
                                        <option value="usd">USD</option>
                                        <option value="euro">EURO</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="currency">{{ __('Budget') }}</label>
                                    <input type="text" name="budget" id="budget"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="lang">{{ __('Languages') }}</label>
                                <select class="js-language-all form-control" multiple="multiple" name="lang[]"
                                        id="lang">
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="summernote" type="text" name="description"
                                          id="description"> {{ old('description') }}</textarea>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="place">Place</label>
                                <input class="form-control sm" type="text" name="place" id="place"
                                       value="{{ old('place') }}">
                            </div>
                            @if(auth()->user()->hasRole('Admin'))
                                <div class="form-group input-group-sm">
                                    <label for="role">Assigned</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif(auth()->user()->hasRole('Manager'))
                                <div class="form-group input-group-sm">
                                    <label for="role">Assigned</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        @foreach(auth()->user()->currentTeam->allUsers() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @can('share-appointment')
                                <div class="form-group form-group-sm">
                                    <label for="share_with">Sell representative</label>
                                    <select class="js-example-basic-multiple form-control" name="share_with[]"
                                            id="share_with" multiple>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan
                            <div class="form-group input-group-sm">
                                <label for="role">Lead</label>
                                <select class="form-control js-client-all" name="client_id" id="client_id"
                                        required>
                                </select>
                            </div>
                            @can('chose-results')
                                <div class="form-group">
                                    <label for="results">Results</label>
                                    <select name="results" id="results" class="form-control form-control-sm">
                                        <option value="0"> - None -</option>
                                        <option value="1">Under evaluation</option>
                                        <option value="2">Postponed</option>
                                        <option value="3">Negative</option>
                                        <option value="4">Appointment not met</option>
                                        <option value="5">Reservation</option>
                                        <option value="6">Reservation Cancellation</option>
                                        <option value="7">Sale</option>
                                        <option value="8">Sale Cancellation</option>
                                        <option value="9">After Sale</option>
                                        <option value="10">Presentation</option>
                                        <option value="11">Follow up</option>
                                    </select>
                                </div>
                            @endcan
                            @can('write-feeback')
                                <div class="form-group">
                                    <label for="feedback">Feedback</label>
                                    <textarea class="summernote" name="feedback" id="feedback"></textarea>
                                </div>
                            @endcan
                            @can('chose-negativity')

                                <div class="form-group">
                                    <label for="negativity">Negativity criterion:</label>
                                    <select name="negativity" id="negativity"
                                            class="form-control form-control-sm">
                                        <option value="1"> - None -</option>
                                        <option value="2">Low Budget</option>
                                        <option value="3">Other Agencies</option>
                                        <option value="4">Trust Issues</option>
                                        <option value="5">Customer not interested</option>
                                        <option value="6">Issues with projects</option>
                                        <option value="7">Issues with payment plans</option>
                                    </select>
                                </div>
                            @endcan

                            <button type="submit" class="btn btn-sm btn-outline-primary"
                                    onClick="this.form.submit(); this.disabled=true; this.value='Sending…';">
                                save
                                <i class="ti-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>

@endsection

