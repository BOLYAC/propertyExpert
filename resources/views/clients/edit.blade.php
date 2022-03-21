@extends('layouts.vertical.master')
@section('title', '| Lead Edit')
@section('style_before')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datedropper.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lightbox.min.css') }}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
    <!-- Datatables.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/todo.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

    <style>
        .mce-menu {
            z-index: 999999999999999 !important;
        }

        .mce-popover {
            z-index: 999999999999999 !important;
        }

        #note-in-modal {
            position: fixed;
            top: 10px;
            right: auto;
            left: 5px;
            bottom: 0;
        }

        .select2-container--open {
            z-index: 999999999999999 !important;
        }
    </style>
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/notify/notify-script.js') }}"></script>
    <!-- Plugins JS start-->
    <script type="{{ asset('assets/js/lightbox.min.js') }}"></script>
    <!-- Plugins JS start-->

    <!-- Datatables.js -->
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        let requirmentData = [
            {
                id: 1,
                text: 'Investments'
            },
            {
                id: 2,
                text: 'Life style'
            },
            {
                id: 3,
                text: 'Investments + Life style'
            },
            {
                id: 4,
                text: 'Citizenship'
            },
        ]
        let roomsData = [
            {
                id: 1,
                text: '0 + 1'
            },
            {
                id: 2,
                text: '1 + 1'
            },
            {
                id: 3,
                text: '2 + 1'
            },
            {
                id: 4,
                text: '3 + 1'
            },
            {
                id: 5,
                text: '4 + 1'
            },
            {
                id: 6,
                text: '5 + 1'
            },
            {
                id: 7,
                text: '6 + 1'
            },
        ]
        let budgetData = [
            {
                id: 1,
                text: 'Less then 50K'
            },
            {
                id: 2,
                text: '50K-100K'
            },
            {
                id: 3,
                text: '100K-150K'
            },
            {
                id: 4,
                text: '150K200K'
            },
            {
                id: 5,
                text: '200K-300K'
            },
            {
                id: 6,
                text: '300K-400k'
            },
            {
                id: 7,
                text: '400k-500K'
            },
            {
                id: 8,
                text: '500K-600k'
            },
            {
                id: 9,
                text: '600K-1M'
            },
            {
                id: 10,
                text: '1M-2M'
            },
            {
                id: 11,
                text: 'More then 2M'
            }
        ]

        //Welcome Message (not for login page)
        function notify(message, type, icon) {
            $.notify({
                    icon: icon,
                    message: message
                },
                {
                    type: type,
                    allow_dismiss: false,
                    newest_on_top: false,
                    mouse_over: false,
                    showProgressbar: false,
                    spacing: 10,
                    timer: 2000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 30,
                        y: 30
                    },
                    delay: 1000,
                    z_index: 10000,
                    animate: {
                        enter: 'animated bounce',
                        exit: 'animated bounce'
                    },
                });
        }

        window.livewire.on('alert', param => {
            notify(param['type'], param['message'], param['icon'])
        })

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#trans-to-sales').on('submit', function (e) {
            e.preventDefault();
            user_id = $('#inCharge').val();
            client_id = '{{ $client->id }}';

            $.ajax({
                url: "{{route('sales.share')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    client_id: client_id,
                },
                success: function () {
                    notify('Client transferred successfully', 'success');
                },
                error: function (response) {
                    notify('already have been assigned to this user', 'danger');
                },
            });
        });

        $('#share_lead_with').on('submit', function (e) {
            e.preventDefault();
            user_id = $('#share_with').val();
            client_id = '{{ $client->id }}';

            $.ajax({
                url: "{{route('sales.shareLead')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    client_id: client_id,
                },
                success: function () {
                    notify('Client transferred successfully', 'success');
                },
                error: function (response) {
                    console.log(response);
                    notify('already have been assigned to this user', 'danger');
                },
            });
        });

        $(document).ready(function () {
            // Start Edit record
            var table = $('#res-config').DataTable();
            table.on('click', '.delete', function () {
                var $this = $(this);
                var row = $this.closest("tr");
                var id = row.data("id");

                $('#deleteForm').attr('action', '/documents/' + id);
                $('#deleteModal').modal('show');
            })
        });
        @can('change-task')
        $('.task-new #assign_task').click(function (e) {
            e.preventDefault();
            var idTask = $(this).data('id');
            $('#task_assigned_id').val(idTask);
            $('#assignModal').modal('show');
        });
        @endcan
        $('.ph1').click(function (e) {
            e.preventDefault();
            let ph = '{{ $client->client_number ?? '' }}'
            $('#output').text(ph);
        });
        $('.ph2').click(function (e) {
            e.preventDefault();
            let ph = '{{ $client->client_number_2 ?? ''}}'
            $('#output').text(ph);
        });
        // Submit Assignment
        $('#assignForm').on('submit', function (e) {
            e.preventDefault();
            let task_assigned_id = $('#task_assigned_id').val();
            let user_id = $('#assigned_user').val();
            $.ajax({
                url: "{{route('tasks.assigne')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    task_assigned_id: task_assigned_id,
                },
                success: function (response) {
                    $('#assignModal').modal('hide');
                    notify('Task assigned', 'success');
                },
                error: function (response) {
                    notify('Something wrong', 'danger');
                }
            });
        });
        $('.js-rooms-all').select2({
            data: roomsData,
            theme: 'classic',
        })
        $('.js-requirements-all').select2({
            data: requirmentData,
            theme: 'classic',
        })
        $('.js-budgets-all').select2({
            data: budgetData,
            theme: 'classic',
        })
        $('.js-flags-all').select2({
            theme: 'classic',
        })


        $(function () {
            $(".js-rooms-all").select2({
                theme: 'classic'
            }).val({!! json_encode($client->rooms_request) !!}).trigger('change.select2');
            $(".js-requirements-all").select2({
                theme: 'classic'
            }).val({!! json_encode($client->requirements_request) !!}).trigger('change.select2');
            $(".js-budgets-all").select2({
                theme: 'classic'
            }).val({!! json_encode($client->budget_request) !!}).trigger('change.select2');
            $(".js-flags-all").select2({
                theme: 'classic'
            }).val({!! json_encode($client->flags) !!}).trigger('change.select2');

        });

        $('.js-country-all').select2({
            theme: 'classic',
            ajax: {
                url: "{{ route('country.name') }}",
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

        $('.js-nationality-all').select2({
            theme: 'classic',
            ajax: {
                url: "{{ route('nationality.name') }}",
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

        $('.js-language-all').select2({
            theme: 'classic',
            ajax: {
                url: "{{ route('language.name') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
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
    <div class="col">
        <li class="breadcrumb-item">{{ __('Leads') }}</li>
    </div>
@endsection

@section('breadcrumb-title')
    <h4>{{ __('Lead') }}: {{ $client->full_name }}</h4>
@endsection

@section('bookmarks-start')
    <div class="col-lg-6">
        <!-- Bookmark Start-->
        <div class="bookmark pull-right">
            <ul>
                @if (isset($previous_record))
                    <li><a class="pr-2" href="{{ route('clients.edit', $previous_record->id) }}">
                            <i data-feather="arrow-left"></i> {{ __('Previous lead') }} </a></li>
                @endif
                @if (isset($next_record))
                    <li><a class="pl-2" href="{{ route('clients.edit', $next_record->id) }}"> {{ __('Next lead') }}
                            <i data-feather="arrow-right"></i></a></li>
                @endif
            </ul>
        </div>
        <!-- Bookmark Ends-->
    </div>
@endsection

@section('content')

    <div class="container-fluid">
        @include('partials.flash-message')
        <div class="row">
            <div class="col-md-9 col-lg-10">
                <div class="card card-with-border b-t-primary">
                    <div class="card-body">
                        <form action="{{ route('clients.update', $client) }}" method="POST" role="form">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Id</label>
                                <input type="text" class="form-control form-control-sm"
                                       value="{{ $client->public_id }}" readonly>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="first_name">{{ __('First
                                                        name') }}</label>
                                            <input type="text" name="first_name" id="first_name"
                                                   class="form-control form-control-sm @error('first_name') form-control-danger @enderror"
                                                   value="{{ old('first_name', $client->first_name) }}">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="last_name">{{ __('Last name') }}</label>
                                            <input type="text" name="last_name" id="last_name"
                                                   class="form-control form-control-sm @error('last_name') form-control-danger @enderror"
                                                   value="{{ old('last_name', $client->last_name) }}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                  <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($client)
                                        <div class="form-group">
                                            <label for="full_name">{{ __('Full name') }}</label>
                                            <input type="text" name="full_name" id="full_name"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('full_name', $client->full_name) }}">
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col">
                                                        <label
                                                            for="client_number_2">{{ __('Phone number Format (+90xxxxxxxxx)') }}</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="https://wa.me/{{$client->client_number}}"
                                                           target="_blank"
                                                           class="btn btn-xs btn-outline-primary float-right theme-setting"><i
                                                                class="fa fa-whatsapp"></i></a>
                                                    </div>
                                                </div>
                                                <input type="text" name="client_number"
                                                       id="client_number"
                                                       class="form-control form-control-sm @error('client_number') form-control-danger @enderror"
                                                       value="{{ old('client_number', $client->client_number) }}"
                                                       @if($client->client_number) @can('cant-update-field') readonly @endcan
                                                    @endif
                                                >
                                                @error('client_number')
                                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                  </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col">
                                                        <label
                                                            for="client_number_2">{{ __('Phone number 2 Format (+90xxxxxxxxx)') }}</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="https://wa.me/{{$client->client_number_2}}"
                                                           target="_blank"
                                                           class="btn btn-xs btn-outline-primary float-right theme-setting ph2"><i
                                                                class="fa fa-whatsapp"></i></a>
                                                    </div>
                                                </div>
                                                <input type="text" name="client_number_2"
                                                       id="client_number_2"
                                                       class="form-control form-control-sm @error('client_number_2') form-control-danger @enderror"
                                                       value="{{ old('client_number_2', $client->client_number_2) }}"
                                                       @if($client->client_number_2) @can('cant-update-field') readonly @endcan
                                                    @endif
                                                >
                                                @error('client_number_2')
                                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                  </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-lg-6">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="client_email">{{ __('E-mail') }}</label>
                                                </div>
                                                <div class="col">
                                                    <a href="{{ route('clients.compose.email', ['email' => $client->client_email_2, 'client' => $client]) }}"
                                                       class="btn btn-xs btn-outline-primary float-right"><i
                                                            class="icon-email"></i></a>
                                                </div>
                                            </div>
                                            <input type="email" name="client_email"
                                                   id="client_email"
                                                   class="form-control form-control-sm @error('client_email') form-control-danger @enderror"
                                                   value="{{ old('client_email', $client->client_email) }}">
                                            @error('client_email')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="client_email_2">{{ __('E-mail 2') }}</label>
                                            <a href="{{ route('clients.compose.email', ['email' => $client->client_email_2, 'client' => $client]) }}"
                                               class="btn btn-xs btn-outline-primary float-right btn-mini"><i
                                                    class="icon-email"></i></a>
                                            <input type="email" name="client_email_2"
                                                   id="client_email_2"
                                                   class="form-control form-control-sm @error('client_email_2') form-control-danger @enderror"
                                                   value="{{ old('client_email_2', $client->client_email_2) }}">
                                            @error('client_email_2')
                                            <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                  </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group input-group-sm">
                                        <label for="country">{{ __('Country') }}</label>
                                        <select class="js-country-all form-control form-control-sm"
                                                multiple="multiple" name="country[]" id="country">
                                            <option></option>
                                            @php $clientCountry = collect($client->country)->toArray() @endphp
                                            @foreach($clientCountry as $lang)
                                                <option value="{{ $lang }}" selected>
                                                    {{ $lang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm">
                                        <label for="nationality">{{ __('Nationality') }}</label>
                                        <select
                                            class="js-nationality-all form-control form-control-sm"
                                            multiple="multiple" name="nationality[]"
                                            id="nationality">
                                            <option></option>
                                            @php $clientNationality = collect($client->nationality)->toArray() @endphp
                                            @foreach($clientNationality as $nat)
                                                <option value="{{ $nat }}" selected>
                                                    {{ $nat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm">
                                        <label for="lang">{{ __('Languages') }}</label>
                                        <select class="js-language-all form-control form-control-sm"
                                                multiple="multiple" name="lang[]" id="lang">
                                            <option></option>
                                            @php $clientLang = collect($client->lang)->toArray() @endphp
                                            @foreach( $clientLang as $lang)
                                                <option vlaue="{{ $lang }}"
                                                        selected> {{ $lang }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="status">{{ __('Status') }}</label>
                                            <select name="status" id="status"
                                                    class="form-control form-control-sm">
                                                <option selected disabled> {{ __('-- Client status --') }}
                                                </option>
                                                @if(auth()->user()->department_id <> 1)
                                                    <option
                                                        value="1" {{ old('status', $client->status) == 1 ? 'selected' : '' }}>
                                                        {{ __('New Lead') }}
                                                    </option>
                                                    <option
                                                        value="8" {{ old('status', $client->status) == 8 ? 'selected' : '' }}>
                                                        {{ __('No Answer') }}
                                                    </option>
                                                    <option
                                                        value="12" {{ old('status', $client->status) == 12 ? 'selected' : '' }}>
                                                        {{ __('In progress') }}
                                                    </option>
                                                    <option
                                                        value="3" {{ old('status', $client->status) == 3 ? 'selected' : '' }}>
                                                        {{ __('Potential appointment') }}
                                                    </option>
                                                    <option
                                                        value="4" {{ old('status', $client->status) == 4 ? 'selected' : '' }}>
                                                        {{ __('Appointment set') }}
                                                    </option>
                                                    <option
                                                        value="10" {{ old('status', $client->status) == 10 ? 'selected' : '' }}>
                                                        {{ __('Appointment follow up') }}
                                                    </option>
                                                    <option
                                                        value="5" {{ old('status', $client->status) == 5 ? 'selected' : '' }}>
                                                        {{ __('Sold') }}
                                                    </option>
                                                    <option
                                                        value="13" {{ old('status', $client->status) == 13 ? 'selected' : '' }}>
                                                        {{ __('Unreachable') }}
                                                    </option>
                                                    <option
                                                        value="7" {{ old('status', $client->status) == 7 ? 'selected' : '' }}>
                                                        {{ __('Not interested') }}
                                                    </option>
                                                    <option
                                                        value="11" {{ old('status', $client->status) == 11 ? 'selected' : '' }}>
                                                        {{ __('Low budget') }}
                                                    </option>
                                                    <option
                                                        value="9" {{ old('status', $client->status) == 9 ? 'selected' : '' }}>
                                                        {{ __('Wrong Number') }}
                                                    </option>
                                                    <option
                                                        value="14" {{ old('status', $client->status) == 14 ? 'selected' : '' }}>
                                                        {{ __('Unqualified') }}
                                                    </option>
                                                    <option
                                                        value="15" {{ old('status', $client->status) == 15 ? 'selected' : '' }}>
                                                        {{ __('Lost') }}
                                                    </option>
                                                @else
                                                    <option
                                                        value="1" {{ old('status', $client->status) == 1 ? 'selected' : '' }}>{{ __('New Lead') }}</option>
                                                    <option
                                                        value="16" {{ old('status', $client->status) == 16 ? 'selected' : '' }}>{{ __('Unassigned') }}</option>
                                                    <option
                                                        value="17" {{ old('status', $client->status) == 17 ? 'selected' : '' }}>{{ __('One Month') }}</option>
                                                    <option
                                                        value="18" {{ old('status', $client->status) == 18 ? 'selected' : '' }}>{{ __('2-3 Months') }}</option>
                                                    <option
                                                        value="19" {{ old('status', $client->status) == 19 ? 'selected' : '' }}>{{ __('Over 3 Months') }}</option>
                                                    <option
                                                        value="20" {{ old('status', $client->status) == 20 ? 'selected' : '' }}>{{ __('In Istanbul') }}</option>
                                                    <option
                                                        value="21" {{ old('status', $client->status) == 21 ? 'selected' : '' }}>{{ __('Agent') }}</option>
                                                    <option
                                                        value="5" {{ old('status', $client->status) == 5 ? 'selected' : '' }}>{{ __('Sold') }}</option>
                                                    <option
                                                        value="15" {{ old('status', $client->status) == 15 ? 'selected' : '' }}>{{ __('Lost') }}</option>
                                                    <option
                                                        value="22" {{ old('status', $client->status) == 22 ? 'selected' : '' }}>{{ __('Transferred') }}</option>
                                                    <option
                                                        value="23" {{ old('status', $client->status) == 23 ? 'selected' : '' }}>{{ __('No Answering') }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="priority">{{ __('Priority') }}</label>
                                            <select name="priority" id="priority"
                                                    class="form-control form-control-sm">
                                                <option selected disabled> {{ __('-- Priority --') }}
                                                </option>
                                                <option
                                                    value="1" {{ $client->priority == '1' ? 'selected' : '' }}>
                                                    {{ __('Low') }}
                                                </option>
                                                <option
                                                    value="2" {{ $client->priority == '2' ? 'selected' : '' }}>
                                                    {{ __('Medium') }}
                                                </option>
                                                <option
                                                    value="3" {{ $client->priority == '3' ? 'selected' : '' }}>
                                                    {{ __('High') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="budget_request">{{ __('Budget') }}</label>
                                        <select name="budget_request[]" id="budget_request"
                                                class="js-budgets-all form-control form-control-sm"
                                                multiple>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="rooms_request">{{ __('Request') }}</label>
                                        <select class="js-rooms-all form-control form-control-sm"
                                                name="rooms_request[]" id="rooms_request" multiple>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="requirements_request">{{ __('Requirement') }}</label>
                                        <select name="requirements_request[]" id="requirements_request"
                                                class="js-requirements-all form-control form-control-sm"
                                                multiple>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm">
                                        <label for="lang">{{ __('Flags') }}</label>
                                        <select class="js-flags-all custom-select custom-select-sm"
                                                multiple="multiple" name="flags[]" id="flags">
                                            @php $clientFlags = collect($client->flags)->toArray() @endphp
                                            @foreach($flags as $flag)
                                                @if( in_array($client->flags, $clientFlags))
                                                    <option value="{{ $flag->id }}"
                                                            selected>{{ $flag->name }}</option>
                                                @else
                                                    <option value="{{ $flag->id }}">{{ $flag->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="source">{{ __('Source') }}</label>
                                            <select name="source_id" id="source"
                                                    class="form-control form-control-sm @error('source_id') form-control-danger @enderror">
                                                <option selected disabled> {{ __('-- Select source --') }}
                                                </option>
                                                @foreach($sources as $source)
                                                    <option value="{{ $source->id }}"
                                                        {{ $client->source_id == $source->id ? 'selected' : '' }}>
                                                        {{ $source->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('source_id')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12 col-lg-6">
                                            <label for="">{{ __('Campaign name') }}</label>
                                            <input type="text" class="form-control form-control-sm"
                                                   value="{{ $client->campaigne_name }}">
                                        </div>


                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                    <textarea class="summernote"
                                              name="description">{{ $client->descirption ?? '' }}</textarea>
                            </div>
                            <!-- end of table col-lg-6 -->
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    {{ __('Save') }} <i class="icon-save"></i></button>
                                <a href="{{ redirect()->route('clients.index') }}" id="edit-cancel"
                                   class="btn btn-sm btn-danger">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
                @include('clients.task-note')
            </div>
            <div class="col-md-3 col-lg-2">
                <div class="card card-with-border">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('Owned by') }}</h5>
                    </div>
                    <div class="card-body pl-2 pr-2 pt-4">
                        <div class="inbox">
                            <div class="media active">
                                <div class="media-size-email">
                                    <img class="mr-3 rounded-circle img-50"
                                         style="width: 50px;height:50px;"
                                         src="{{ asset('storage/' . $client->user->image_path) }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $client->user->name }}</h6>
                                    <p>{{ $client->user->roles->first()->name }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @can('share-client')
                            <form id="trans-to-sales">
                                @csrf
                                <div class="form-group form-group-sm">
                                    <select class="form-control form-control-sm" name="inCharge" id="inCharge">
                                        @foreach($users as $user)
                                            <option
                                                value="{{ $user->id }}" {{ $client->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary form-control form-control-sm">
                                    {{ __('Change') }} <i
                                        class="icon-share-alt"></i></button>
                            </form>
                        @endcan
                    </div>
                </div>

                <!-- Transfer to invoice -->
                @can('transfer-lead-to-deal')
                    <div class="card">
                        <div class="card-header b-b-info">
                            <h5 class="text-muted">{{ __('Transfer to deal') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.transfer') }}" method="POST">
                                @csrf
                                <input type="hidden" name="clientId" value="{{ $client->id }}">
                                <button class="btn btn-outline-success btn-sm form-control"
                                        id="tran-to">{{ __('Done') }} <i
                                        class="icon-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                @endcan
                @include('clients.documents.index')
                @if($client->leads()->exists())
                    <div class="card card-with-border">
                        <div class="card-header">
                            <h5 class="d-inline-block">{{ __('Deals history') }}</h5>
                        </div>
                        <div class="card-body activity-social">
                            <ul>
                                @foreach($client->leads as $lead)
                                    <li class="border-recent-success">
                                        <small>{{ $lead->created_at->format('Y-m-d') }}</small>
                                        <p class="mb-0">{{ __('Stage') }}: <span
                                                class="f-w-800 text-primary">
                                                @php
                                                    $i = $lead->stage_id;
                                                switch ($i) {
                                                    case 1:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('In contact') . '</span>';
                                                        break;
                                                    case 2:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Appointment Set') . '</span>';
                                                        break;
                                                    case 3:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Follow up') . '</span>';
                                                        break;
                                                    case 4:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Reservation') . '</span>';
                                                        break;
                                                    case 5:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Contract signed') . '</span>';
                                                        break;
                                                    case 6:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Down payment') . '</span>';
                                                        break;
                                                    case 7:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Developer invoice') . '</span>';
                                                        break;
                                                    case 8:
                                                        echo '<span class="badge badge-light-success f-w-600">' . __('Won Deal') . '</span>';
                                                        break;
                                                    case 9:
                                                        echo '<span class="badge badge-light-danger f-w-600">' . __('Lost') . '</span>';
                                                        break;
                                                }
                                                @endphp
                                        </span></p>
                                        <p>{{ __('Name') }} <a
                                                href="{{ route('leads.show', $lead) }}">{{ $lead->lead_name }}</a></p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if($client->StatusLog()->exists())
                    <div class="card card-with-border">
                        <div class="card-header">
                            <h5 class="d-inline-block">{{ __('Status activity') }}</h5>
                        </div>
                        <div class="card-body activity-social">
                            <ul>
                                @foreach($client->StatusLog as $log)
                                    <li class="border-recent-warning">
                                        <small>{{ $log->created_at->format('Y-m-d H:i') }}</small>
                                        <p class="mb-0">{{ __('Status change to') }}: <span
                                                class="f-w-800 text-primary">{{ $log->status_name }}</span></p>
                                        <P>by <a href="#">{{ $log->user_name }}</a></P>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="card card-with-border">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('History') }}</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ __('Modified By:') }} </h6>
                        <p>{{ $client->updateBy->name }}</p>
                        <h6>{{ __('Created time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($client->created_at)->format('Y-m-d H:m') }}
                        </p>
                        <h6>{{ __('Modified time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($client->updated_at)->format('Y-m-d H:m') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
    <!-- Create modal end -->
    <!-- Delete file modal start -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete file</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/documents" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-b-0">
                        <p>Are sur you want to delete?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete <i class="ti-trash-alt"></i></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete file modal end -->
    <!-- Assign modal start -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Assign to a user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="assignForm">
                    @csrf
                    <div class="modal-body p-b-0">
                        <input type="hidden" name="task_assigned_id" id="task_assigned_id">
                        <div class="form-group">
                            <select class="form-control" name="assigned_user" id="assigned_user">
                                <option value="" selected>{{ __('-- Select user --') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }} <i class="ti-save-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit modal end -->
@endsection
