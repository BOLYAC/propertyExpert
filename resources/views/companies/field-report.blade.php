@extends('layouts.vertical.master')
@section('title', '| Companies reports')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterange-picker.css') }}">
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .select2-search input {
            font-size: 12px;
        }

        .select2-results {
            font-size: 12px;
        }

        .select2-results__option--highlighted {
            font-size: 12px;
        }

        .select2-results__option[aria-selected=true] {
            font-size: 12px;
        }

        .select2-results__options {
            font-size: 12px !important;
        }

        .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-selection__rendered {
            line-height: 16px !important;
        }

        .select2-container .select2-selection--single {
            height: 16px !important;
        }

        .select2-selection__arrow {
            height: 16px !important;
        }
    </style>
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/datepicker/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script>
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
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <!-- Notify -->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script>
        // Notify
        function notify(title, type) {
            $.notify({
                    title: title
                },
                {
                    type: type,
                    allow_dismiss: true,
                    newest_on_top: true,
                    mouse_over: true,
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
                    }
                });
        }

        // Refresh filter
        $('#refresh').click(function () {
            $('select[name=user_filter]').val('');
            $('select[name=team_filter]').val('');
            $('select[name=department_filter]').val('');
            $('#last_active').val('');
            $('#no_tasks').prop('checked', false);
            $('input[name=daterange]').val('')
            $('input[type="radio"]').filter('[value=none]').prop('checked', true);
        });
        // Search form
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            function get_filter(class_name) {
                let filter = [];
                $('.' + class_name + ':checked').each(function () {
                    filter.push($(this).val());
                });
                return filter;
            }

            function get_filter_status(class_name) {
                let filter = [];
                $('.' + class_name + ':checked').each(function () {
                    filter.push($(this).val());
                });
                return filter;
            }

            function get_filter_status_new(class_name) {
                let filter = [];
                $('.' + class_name + ':checked').each(function () {
                    filter.push($(this).val());
                });
                return filter;
            }


            $.ajax({
                url: "{{ route('companies.field.report.post') }}",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                type: "POST",
                data: {
                    user: $('select[name=user_filter]').val(),
                    team: $('select[name=team_filter]').val(),
                    department: $('select[name=department_filter]').val(),
                    daysActif: $('#last_active').val(),
                    lastUpdate: $('#no_tasks').is(':checked'),
                    daterange: $('input[name=daterange]').val(),
                    filterDateBase: $('input[type="radio"]:checked').val(),
                    fields: get_filter('field')
                },
                success: function (response) {
                    notify('Report generated successfully', 'success');
                    $('.custom-table').html(response);
                    initTable()
                },
                error: function (response) {
                    notify('You have to select minimum 3 fields!', 'danger');
                }
            });
        });
        $(document).ready(function () {
            $('input[name=daterange]').val('')
        });

        function initTable() {
            let table = $('#report-table').DataTable({
                @can('can-generate-report')
                dom: 'lfrtBip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
        }
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Leads') }}</a></li>
    <li class="breadcrumb-item">{{ __('Select fields:') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero config.table start -->
            <div class="col-sm-2">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">{{ __('Filter leads by:') }}</h6>
                    </div>
                    <form id="search-form">
                        <div class="card-body filter-cards-view animate-chk p-2">
                            @if(isset($departments))
                                <div class="form-group mb-2">
                                    <div class="col-form-label">{{ __('Departments') }}</div>
                                    <select name="department_filter" id="department_filter"
                                            class="js-example-placeholder-multiple col-sm-12" multiple>
                                        <option value="">{{ __('Department') }}</option>
                                        @foreach($departments as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if(isset($teams))
                                <div class="form-group mb-2">
                                    <div class="col-form-label">{{ __('Team') }}</div>
                                    <select name="team_filter" id="team_filter"
                                            class="js-example-placeholder-multiple col-sm-12" multiple>
                                        <option value="">{{ __('Team') }}</option>
                                        @foreach($teams as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if(isset($users))
                                <div class="form-group mb-2">
                                    <div class="col-form-label">{{ __('Assigned') }}</div>
                                    <select class="js-example-placeholder-multiple col-sm-12" name="user_filter"
                                            id="user_filter" multiple="multiple">
                                        @foreach($users as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="form-group mb-2">
                                <input type="text" class="form-control form-control-sm"
                                       placeholder="{{ __('Last active') }}"
                                       id="last_active" name="last_active">
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="no_tasks" type="checkbox">
                                <label for="no_tasks" nonce="no_tasks">{{ __('No tasks') }}</label>
                            </div>
                            <div class="theme-form mb-2">
                                <input class="form-control form-control-sm digits" type="text" name="daterange"
                                       value="">
                            </div>
                            <div class="form-group">
                                <label class="d-block" for="edo-ani">
                                    <input class="radio_animated" id="edo-ani" type="radio" name="rdo-ani"
                                           value="creation"> {{ __('Creation') }}
                                </label>
                                <label class="d-block" for="edo-ani1">
                                    <input class="radio_animated" id="edo-ani1" type="radio" name="rdo-ani"
                                           value="modification"> {{ __('Modification') }}
                                </label>
                                <label class="d-block" for="edo-ani13">
                                    <input class="radio_animated" id="edo-ani13" type="radio" name="rdo-ani" checked
                                           value="none"> {{ __('None') }}
                                </label>
                            </div>
                        </div>
                        <div class="card-footer p-2">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary" type="submit">{{ __('Filter') }}</button>
                                <button class="btn btn-light" type="button" id="refresh">{{ __('Clear') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header b-t-primary b-b-primary">
                        <div class="row">
                            @foreach($newArr as $k => $value)
                                <div class="col-2" data-aos="fade-right" data-aos-duration="2000">
                                    <label>
                                        <input type="checkbox" name="fields[]"
                                               value="{{ $value }}" class="field">
                                        {{ __('leads-report.' . $value) }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="col-2" data-aos="fade-right" data-aos-duration="2000">
                                <label>
                                    <input type="checkbox" name="fields[]"
                                           value="tasks" class="field"> {{ __('Tasks') }} </label>
                            </div>
                            <div class="col-2" data-aos="fade-right" data-aos-duration="2000">
                                <label>
                                    <input type="checkbox" name="fields[]"
                                           value="notes" class="field"> {{ __('Notes') }} </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table">

                        </div>
                    </div>
                    <div class="card-footer b-t-primary p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
