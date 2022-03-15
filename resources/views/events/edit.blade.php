@extends('layouts.vertical.master')
@section('title', '| Appointment edit')

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
        let budgetData = [
            {
                id: 1,
                text: 'Less then 50K'
            },
            {
                id: 2,
                text: '50K <> 100K'
            },
            {
                id: 3,
                text: '100K <> 150K'
            },
            {
                id: 4,
                text: '150K <> 200K'
            },
            {
                id: 5,
                text: '200K <> 300K'
            },
            {
                id: 6,
                text: '300K <> 400k'
            },
            {
                id: 7,
                text: '400k <> 500K'
            },
            {
                id: 8,
                text: '500K <> 600k'
            },
            {
                id: 9,
                text: '600K <> 1M'
            },
            {
                id: 10,
                text: '1M <> 2M'
            },
            {
                id: 11,
                text: 'More then 2M'
            }
        ]

        $('.js-budgets-all').select2({
            data: budgetData,
            theme: 'classic',
        })

        $(function () {
            $(".js-budgets-all").select2({
                theme: 'classic'
            }).val({!! json_encode($event->lead_budget) !!}).trigger('change.select2');
        });
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
        $(function () {
            if ($('#results').val() === '3') {
                $('#negative-form').show();
                console.log($('#results').val())
            } else {
                $('#negative-form').hide();
            }
            $('#results').change(function () {
                if ($('#results').val() === '3') {
                    $('#negative-form').show();
                } else {
                    $('#negative-form').hide();
                }
            })
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">{{ __('Appointments') }}</a></li>
    <li class="breadcrumb-item">{{ __('Appointment edit') }}</li>
@endsection

@section('breadcrumb-title')

@endsection

@section('script')
    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <script>
        let budgetData = [
            {
                id: 1,
                text: 'Less then 50K'
            },
            {
                id: 2,
                text: '50K <> 100K'
            },
            {
                id: 3,
                text: '100K <> 150K'
            },
            {
                id: 4,
                text: '150K <> 200K'
            },
            {
                id: 5,
                text: '200K <> 300K'
            },
            {
                id: 6,
                text: '300K <> 400k'
            },
            {
                id: 7,
                text: '400k <> 500K'
            },
            {
                id: 8,
                text: '500K <> 600k'
            },
            {
                id: 9,
                text: '600K <> 1M'
            },
            {
                id: 10,
                text: '1M <> 2M'
            },
            {
                id: 11,
                text: 'More then 2M'
            }
        ]

        $('.js-budgets-all').select2({
            data: budgetData,
            theme: 'classic',
        })

        $(function () {
            $(".js-budgets-all").select2({
                theme: 'classic'
            }).val({!! json_encode($event->lead_budget) !!}).trigger('change.select2');
        });
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
        $(function () {
            if ($('#results').val() === '3') {
                $('#negative-form').show();
                console.log($('#results').val())
            } else {
                $('#negative-form').hide();
            }
            $('#results').change(function () {
                if ($('#results').val() === '3') {
                    $('#negative-form').show();
                } else {
                    $('#negative-form').hide();
                }
            })
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">{{ __('Events') }}</a></li>
    <li class="breadcrumb-item">{{ __('Show event') }}</li>
@endsection

@section('breadcrumb-title')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('events.update', $event) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col-6">
                                    <label for="name">{{ __('Title') }}</label>
                                    <input class="form-control sm" type="text" name="name" id="name"
                                           value="{{ old('name', $event->name) }}">
                                </div>
                                <div class="form-group input-group-sm col-6">
                                    <label for="event_date">{{ __('Date of appointment') }}</label>
                                    <input name="event_date" id="event_date" class="form-control"
                                           onclick="myFunction()"
                                           value="{{ old('event_date', Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i')) }}"
                                           type="datetime-local"/>
                                </div>
                                <div class="form-group input-group-sm col-12">
                                    <label for="color">{{ __('Colors') }}</label>
                                    <div>
                                        <input id="color" name="color" type="color" list="presetColors"
                                               value="{{ $event->color }}">
                                        <datalist id="presetColors">
                                            <option {{ $event->color === '#0B8043' ? 'selected' : '' }}>
                                                #0B8043
                                            </option>
                                            <option {{ $event->color === '#D50000' ? 'selected' : '' }}>
                                                #D50000
                                            </option>
                                            <option {{ $event->color === '#F4511E' ? 'selected' : '' }}>
                                                #F4511E
                                            </option>
                                            <option {{ $event->color === '#8E24AA' ? 'selected' : '' }}>
                                                #8E24AA
                                            </option>
                                            <option {{ $event->color === '#3F51B5' ? 'selected' : '' }}>
                                                #3F51B5
                                            </option>
                                            <option {{ $event->color === '#039BE5' ? 'selected' : '' }}>
                                                #039BE5
                                            </option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="form-group input-group-sm col-2">
                                    <label for="currency">{{ __('Currency') }}</label>
                                    <select class="form-control form-control-sm" id="currency" name="currency">
                                        <option value="try" {{ $event->currency === 'try' ? 'selected' : '' }}>
                                            TRY
                                        </option>
                                        <option value="usd" {{ $event->currency === 'usd' ? 'selected' : '' }}>
                                            USD
                                        </option>
                                        <option value="eur" {{ $event->currency === 'eur' ? 'selected' : '' }}>
                                            EURO
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col">
                                    <div class="form-group col-lg">
                                        <label for="lead_budget">{{ __('Budget') }}</label>
                                        <select name="lead_budget[]" id="lead_budget"
                                                class="js-budgets-all form-control form-control-sm"
                                                multiple>
                                        </select>
                                        @if(is_null($event->budget))
                                            <div class="col-form-label">
                                                <span>{{ __('Old:') }} <b>{{ $event->budget }}</b></span></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control sm" type="text" name="description"
                                          id="description"> {{ old('description', $event->description) }}</textarea>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="place">{{ __('Place') }}</label>
                                <input class="form-control sm" type="text" name="place" id="place"
                                       value="{{ old('place', $event->place) }}">
                            </div>
                            @can('share-lead')
                                <div class="form-group input-group-sm">
                                    <label for="role">{{ __('Assigned') }}</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        @if(auth()->user()->hasRole('Admin'))

                                            @foreach($users as $user)
                                                <option
                                                    value="{{ $user->id }}" {{ $event->user_id === $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        @elseif(auth()->user()->hasRole('Manager'))
                                            @foreach(auth()->user()->currentTeam->allUsers() as $user)
                                                <option
                                                    value="{{ $user->id }}" {{ $event->user_id === $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endcan

                            @can('share-appointment')
                                <div class="form-group form-group-sm">
                                    <label for="share_with">{{ __('Sell representative') }}</label>
                                    <select class="js-example-basic-multiple form-control" name="share_with[]"
                                            id="share_with" multiple>
                                        @foreach($users as $user)
                                            @if($event->SharedEvents->contains($user))
                                                <option value="{{ $user->id }}"
                                                        selected>{{ $user->name }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endcan

                            <div class="form-group input-group-sm">
                                <label for="role">{{ __('Client') }}</label>
                                <select class="form-control js-client-all" name="client_id" id="client_id">
                                    <option value="{{ $event->client_id }}"
                                            selected>{{ $event->client->full_name ?? ''}}</option>
                                </select>
                            </div>

                            @can('chose-results')
                                <div class="form-group">
                                    <label for="results">{{ __('Results') }}</label>
                                    <select name="results" id="results" class="form-control form-control-sm">
                                        <option value="0"> - None -</option>
                                        <option value="1" {{ $event->results === '1' ? 'selected' : '' }}>
                                            {{ __('Under evaluation') }}
                                        </option>
                                        <option value="2" {{ $event->results === '2' ? 'selected' : '' }}>
                                            {{ __('Postponed') }}
                                        </option>
                                        <option value="3" {{ $event->results === '3' ? 'selected' : '' }}>
                                            {{ __('Negative') }}
                                        </option>
                                        <option value="4" {{ $event->results === '4' ? 'selected' : '' }}>
                                            {{ __('Appointment not met') }}
                                        </option>
                                        <option value="5" {{ $event->results === '5' ? 'selected' : '' }}>
                                            {{ __('Reservation') }}
                                        </option>
                                        <option value="6" {{ $event->results === '6' ? 'selected' : '' }}>
                                            {{ __('Reservation Cancellation') }}
                                        </option>
                                        <option value="7" {{ $event->results === '7' ? 'selected' : '' }}>
                                            {{ __('Sale') }}
                                        </option>
                                        <option value="8" {{ $event->results === '8' ? 'selected' : '' }}>
                                            {{ __('Sale Cancellation') }}
                                        </option>
                                        <option value="9" {{ $event->results === '9' ? 'selected' : '' }}>
                                            {{ __('After Sale') }}
                                        </option>
                                        <option value="10" {{ $event->results === '10' ? 'selected' : '' }}>
                                            {{__('Presentation')}}
                                        </option>
                                        <option value="11" {{ $event->results === '11' ? 'selected' : '' }}>
                                            {{ __('Follow up') }}
                                        </option>
                                    </select>
                                </div>
                            @endcan

                            @can('write-feedback')
                                <div class="form-group">
                                    <label for="feedback">{{ __('Feedback') }}</label>
                                    <textarea name="feedback" class="summernote"
                                              id="feedback">{{ old('feedback', $event->feedback) }}</textarea>
                                </div>
                            @endcan
                            @can('chose-negativity')
                                <div class="form-group" id="negative-form">
                                    <label for="negativity">{{ __('Negativity criterion:') }}</label>
                                    <select name="negativity" id="negativity"
                                            class="form-control form-control-sm">
                                        <option value="1" {{ $event->negativity === '1' ? 'selected' : '' }}>
                                            - {{ __('None') }} -
                                        </option>
                                        <option value="2" {{ $event->negativity === '2' ? 'selected' : '' }}>
                                            {{ __('Low Budget') }}
                                        </option>
                                        <option value="3" {{ $event->negativity === '3' ? 'selected' : '' }}>
                                            {{ __('Other Agencies') }}
                                        </option>
                                        <option value="4" {{ $event->negativity === '4' ? 'selected' : '' }}>
                                            {{ __('Trust Issues') }}
                                        </option>
                                        <option value="5" {{ $event->negativity === '5' ? 'selected' : '' }}>
                                            {{ __('Customer not interested') }}
                                        </option>
                                        <option value="6" {{ $event->negativity === '6' ? 'selected' : '' }}>
                                            {{ __('Issues with projects') }}
                                        </option>
                                        <option value="7" {{ $event->negativity === '7' ? 'selected' : '' }}>
                                            {{ __('Issues with payment plans') }}
                                        </option>
                                    </select>
                                </div>
                            @endcan
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ redirect()->route('events.index') }}" id="edit-cancel"
                               class="btn btn-warning btn-sm">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header b-b-primary">
                        <h5 class="text-muted">{{ __('Owned by') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="inbox">
                            <div class="media active">
                                <div class="media-size-email">
                                    <img class="mr-3 rounded-circle"
                                         src="{{ asset('/assets/images/user/user.png') }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $event->user->name }}</h6>
                                    <p>{{ $event->user->roles->first()->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header b-b-primary">
                        <h6 class="text-muted">
                            @if($event->client)
                                <a href="{{ route('clients.edit', $event->client) }}">{{ $event->client->full_name ?? '' }}</a>
                            @else
                                {{ $event->lead_name ?? '' }}
                            @endif
                        </h6>
                    </div>
                    <div class="card-body">
                        @if(is_null($event->client))
                            <p><b>{{ __('Phone number:') }}</b><br>{{ $event->lead_phone ?? '' }}</p>
                            <p><b>{{ __('Email:') }}</b><br>{{ $event->lead_email ?? '' }}</p>
                        @else
                            <p><b>{{ __('Phone number:') }}</b><br>{{ $event->client->client_number ?? '' }}</p>
                            <p><b>{{ __('Email:') }}</b><br>{{ $event->client->client_email ?? '' }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
