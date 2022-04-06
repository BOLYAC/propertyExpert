@extends('layouts.vertical.master')
@section('title', '| Leads')
@section('style_before')
    <!-- Datatables.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterange-picker.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .jconfirm.jconfirm-supervan .jconfirm-box div.jconfirm-content {
            overflow: hidden
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
    <!-- Datatables.js -->
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.colReorder.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/datepicker/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script>
    <!-- Notify -->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script>
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

        // Main data table
        let tableNew = $('#basic-1').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: false,
            ajax: {
                url: '{!! route('clients.newLeadList') !!}',
                data: function (d) {
                    d.status = $('select[name=status_filter]').val();
                    d.source = $('select[name=source_filter]').val();
                    d.flags = $('select[name=client_flags_filter]').val();
                    d.priority = $('select[name=priority_filter]').val();
                    d.country_check = $('#country_check').is(':checked');
                    d.country_type = $('select[name=country_type]').val();
                    d.country = $('input[name=country_field]').val();
                    d.phone_check = $('#phone_check').is(':checked');
                    d.phone_type = $('select[name=phone_type]').val();
                    d.phone = $('input[name=phone_field]').val();
                    d.user = $('select[name=user_filter]').val();
                    d.daysActif = $('#last_active').val();
                    d.lastUpdate = $('#no_tasks').is(':checked');
                    d.daterange = $('input[name=daterange]').val()
                    d.filterDateBase = $('input[type="radio"]:checked').val();
                }
            },
            columns: [
                {data: 'id', name: 'id', visible: false},
                {data: 'check', name: 'check', orderable: false, searchable: false},
                {data: 'details', name: 'details', orderable: false, searchable: false},
                {data: 'more_details', name: 'more_details', orderable: false, searchable: false},
                {data: 'full_name', name: 'full_name', orderable: false, visible: false},
                {data: 'client_email', name: 'client_email', orderable: false, visible: false},
                {data: 'client_number', name: 'client_number', orderable: false, visible: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        // Assigne user
        $('#refresh').click(function () {
            $('select[name=status_filter]').val('');
            $('select[name=source_filter]').val('');
            $('select[name=client_flags_filter]').val('');
            $('select[name=priority_filter]').val('');
            $('#country_check').prop('checked', false);
            $('input[name=country_field]').val('');
            $('#phone_check').prop('checked', false);
            $('input[name=phone_field]').val('');
            $('select[name=user_filter]').val('');
            $('#last_active').val('');
            $('#no_tasks').prop('checked', false);
            $('input[name=daterange]').val('')
            $('input[type="radio"]').filter('[value=none]').prop('checked', true);
            valueChanged()
            valuePhoneChanged()
            tableNew.DataTable().destroy();
        });
        // Search form
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            tableNew.draw();
        });
        // Check/Uncheck ALl
        $('#checkAll').change(function () {
            if ($(this).is(':checked')) {
                $('.checkbox-circle').prop('checked', true);
            } else {
                $('.checkbox-circle').each(function () {
                    $(this).prop('checked', false);
                });
            }
        });
        @can('share-client')
        // Select all, trigger modal
        $('#row-select-btn').on('click', function (e) {
            e.preventDefault();
            let filter = [];
            $('.checkbox-circle:checked').each(function () {
                filter.push($(this).val());
            });
            if (filter.length > 0) {
                $('#massAssignModal').modal('show');
            } else {
                notify('At least select one lead!', 'danger');
            }
        });
        @endcan
        // Mass assign modal
        $('#massAssignForm').on('submit', function (e) {
            e.preventDefault();
            let ids = [];
            $('.checkbox-circle:checked').each(function () {
                ids.push($(this).val());
            });
            $.ajax({
                url: "{{ route('sales.share.mass') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: $('#assigned_user_mass').val(),
                    clients: ids,
                },
                success: function (response) {
                    tableNew.ajax.reload(null, false);
                    $('#massAssignModal').modal('hide');
                    notify('Lead transferred', 'success');
                },
            });
        });
        @can('share-client-with')
        // Select all, trigger modal
        $('#row-share-btn').on('click', function (e) {
            e.preventDefault();
            let filter = [];
            $('.checkbox-circle:checked').each(function () {
                filter.push($(this).val());
            });
            if (filter.length > 0) {
                $('#massShareLeadModal').modal('show');
            } else {
                notify('At least select one lead!', 'danger');
            }
        });
        @endcan
        // Mass assign modal
        $('#massShareForm').on('submit', function (e) {
            e.preventDefault();
            let ids = [];
            let data = $('#share_mass_lead').val();
            $('.checkbox-circle:checked').each(function () {
                ids.push($(this).val());
            });
            $.ajax({
                url: "{{ route('client.massShareClient') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    users_ids: data,
                    clients: ids,
                },
                success: function (response) {
                    tableNew.ajax.reload(null, false);
                    $('#massShareLeadModal').modal('hide');
                    notify('Leads shared', 'success');
                },
            });
        });
        @can('client-delete')
        tableNew.on('click', '.delete', function (e) {
            e.preventDefault();
            let $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }
            let data = tableNew.row($tr).id()
            $('#lead_id_delete').val(data);
            $('#delete_single_lead').modal('show');
        });
        @endcan
        @can('client-delete')
        $('#deleteLeadForm').on('submit', function (e) {
            e.preventDefault();
            let client_id = $('#lead_id_delete').val();
            $.ajax({
                url: "/clients/singleDelete/" + client_id,
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    tableNew.ajax.reload(null, false);
                    $('#delete_single_lead').modal('hide');
                    $('#lead_id_delete').val('');
                    notify('Lead deleted', 'success', 'fa fa-check mr-5');
                },
                error: function (response) {
                    $('#lead_id_delete').val('');
                    $('#delete_single_lead').modal('hide');
                    notify(response, 'danger', 'fa fa-times mr-5');
                }
            });
        });
        @endcan
        @can('client-delete')
        // Select all, trigger modal
        $('#row-delete-btn').on('click', function (e) {
            e.preventDefault();
            let filter = [];
            $('.checkbox-circle:checked').each(function () {
                filter.push($(this).val());
            });
            if (filter.length > 0) {
                $('#delete_mass_lead_model').modal('show');
            } else {
                notify('At least select one lead!', 'danger');
            }
        });
        @endcan
        // Mass assign modal
        $('#deleteMassLeadForm').on('submit', function (e) {
            e.preventDefault();
            let ids = [];
            $('.checkbox-circle:checked').each(function () {
                ids.push($(this).val());
            });
            $.ajax({
                url: "{{ route('clients.massDelete') }}",
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}",
                    clients: ids,
                },
                success: function (response) {
                    tableNew.ajax.reload(null, false);
                    $('#delete_mass_lead_model').modal('hide');
                    notify('Lead transferred', 'success');
                },
            });
        });

        // Filtration sidebar
        $("#cts_select").hide();
        $("#pts_select").hide();


        $(document).ready(function () {
            $('input[name=daterange]').val('')
        });


        function valueChanged() {
            if ($('#country_check').is(":checked"))
                $("#cts_select").show();
            else
                $("#cts_select").hide();
        }

        function valuePhoneChanged() {
            if ($('#phone_check').is(":checked"))
                $("#pts_select").show();
            else
                $("#pts_select").hide();
        }

    </script>

@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Leads') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">{{ __('Filter leads by:') }}</h6>
                    </div>
                    <form id="search-form">
                        <div class="card-body filter-cards-view p-2">
                            @isset($users)
                                <div class="form-group mb-2">
                                    <div class="col-form-label">{{ __('Assigned') }}</div>
                                    <select name="user_filter" id="user_filter"
                                            class="js-example-placeholder-multiple col-sm-12" multiple>
                                        <option value="">{{ __('Team') }}</option>
                                        @foreach($users as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endisset
                            <div class="form-group mb-2">
                                <div class="col-form-label">{{ __('Status') }}</div>
                                <select class="js-example-placeholder-multiple col-sm-12" id="status_filter"
                                        name="status_filter" multiple="multiple">
                                    <option value="1">{{ __('New Lead') }}</option>
                                    <option value="8">{{ __('No Answer') }}</option>
                                    <option value="12">{{ __('In progress') }}</option>
                                    <option value="3">{{ __('Potential appointment') }}</option>
                                    <option value="4">{{ __('Appointment set') }}</option>
                                    <option value="10">{{ __('Appointment follow up') }}</option>
                                    <option value="5">{{ __('Sold') }}</option>
                                    <option value="13">{{ __('Unreachable') }}</option>
                                    <option value="7">{{ __('Not interested') }}</option>
                                    <option value="11">{{ __('Low budget') }}</option>
                                    <option value="9">{{ __('Wrong Number') }}</option>
                                    <option value="14">{{ __('Unqualified') }}</option>
                                    <option value="15">{{ __('Lost') }}</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <div>{{ __('Source') }}</div>
                                <select class="js-example-placeholder-multiple col-sm-12" id="source_filter"
                                        name="source_filter" multiple>
                                    @foreach($sources as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <div>{{ __('Flags') }}</div>
                                <select class="js-example-placeholder-multiple col-sm-12" id="client_flags_filter"
                                        name="client_flags_filter" multiple>
                                    @foreach($flags as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <div>{{ __('Priority')  }}</div>
                                <select class="js-example-placeholder-multiple col-sm-12" id="priority_filter"
                                        name="priority_filter" multiple>
                                    <option value="1">{{ __('Low') }}</option>
                                    <option value="2">{{ __('Medium') }}</option>
                                    <option value="3">{{ __('High') }}</option>
                                </select>
                            </div>

                            <div class="checkbox checkbox-primary">
                                <input id="country_check" type="checkbox"
                                       onclick="valueChanged()">
                                <label for="country_check">{{ __('Country') }}</label>
                            </div>
                            <div class="form-group mb-2 ml-2" id="cts_select">
                                <select class="custom-select custom-select-sm mb-1" id="country_type"
                                        name="country_type">
                                    <option value="1">{{ __('is') }}</option>
                                    <option value="2">{{ __('isn\'t') }}</option>
                                    <option value="3">{{ __('contains') }}</option>
                                    <option value="4">{{ __('dosen\'t contain') }}</option>
                                    <option value="5">{{ __('start with') }}</option>
                                    <option value="6">{{ __('ends with') }}</option>
                                    <option value="7">{{ __('is empty') }}</option>
                                    <option value="8">{{ __('is note empty') }}</option>
                                </select>
                                <input type="text" class="form-control form-control-sm"
                                       placeholder="{{ __('Type here') }}"
                                       id="country_field" name="country_field">
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="phone_check" type="checkbox"
                                       onclick="valuePhoneChanged()">
                                <label for="phone_check">{{ __('Phone') }}</label>
                            </div>
                            <div class="form-group mb-2 ml-2" id="pts_select">
                                <select class="custom-select custom-select-sm mb-1" id="phone_type"
                                        name="phone_type">
                                    <option value="1">{{ __('is') }}</option>
                                    <option value="2">{{ __('isn\'t') }}</option>
                                    <option value="3">{{ __('contains') }}</option>
                                    <option value="4">{{ __('dosen\'t contain') }}</option>
                                    <option value="5">{{ __('start with') }}</option>
                                    <option value="6">{{ __('ends with') }}</option>
                                    <option value="7">{{ __('is empty') }}</option>
                                    <option value="8">{{ __('is note empty') }}</option>
                                </select>
                                <input type="text" class="form-control form-control-sm"
                                       placeholder="{{ __('Type here') }}"
                                       id="phone_field" name="phone_field">
                            </div>
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
                                <label class="d-block" for="edo-ani2">
                                    <input class="radio_animated" id="edo-ani2" type="radio" name="rdo-ani"
                                           value="arrival"> {{ __('Arrival') }}
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
                <div class="card p-1">
                    <div class="card-header card-no-border p-2 b-t-primary row">
                        <div class="col-lg-6 col-md-12 pr-1 pl-1">
                            @can('share-client')
                                <div class="btn-group btn-group-xs btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-primary btn-sm">
                                        <input id="checkAll" type="checkbox" checked
                                               autocomplete="off">{{ __('Select/Unselect') }}
                                    </label>
                                </div>
                                <button type="button" id="row-select-btn" class="btn btn-primary btn-sm">
                                    {{ __('Assign Lead') }}
                                </button>
                                <button type="button" id="row-share-btn" class="btn btn-primary btn-sm">
                                    {{ __('Share Lead') }}
                                </button>
                                <button type="button" id="row-delete-btn" class="btn btn-danger btn-sm">
                                    {{ __('Delete') }}
                                </button>
                            @endcan
                        </div>
                        <div class="col-lg-6 col-md-12 pr-1 pl-1">
                            @if(auth()->user()->hasRole('Admin'))
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('importExportZoho') }}">
                                    {{ __('Zoho Import') }}
                                </a>
                            @endif
                            @can('client-import')
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('importExport') }}">
                                    {{ __('Leads Import') }}
                                </a>
                            @endcan
                            @can('client-create')
                                <a href="{{ route('clients.create') }}"
                                   class="btn btn-sm btn-outline-success">
                                    {{ __('New lead') }}
                                </a>
                            @endcan
                            @can('client-create')
                                <a href="{{ route('clients.field.report') }}"
                                   class="btn btn-sm btn-outline-success">
                                    {{ __('Generate report') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-1 b-t-primary">
                        <div class="dt-ext table-responsive product-table">
                            <table class="table table-striped display table-bordered nowrap" id="basic-1" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th data-priority="1" width="5%"></th>
                                    <th data-priority="1">Lead</th>
                                    <th>Details</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th width="2%">Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mass Assign -->
    <div class="modal fade" id="massAssignModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Assign to user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="massAssignForm">
                    @csrf
                    <div class="modal-body p-b-0">
                        <div class="form-group">
                            <select class="form-control" name="assigned_user_mass" id="assigned_user_mass">
                                <option value="" selected>-- {{ __('Select user') }} --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }} <i class="icon-save"></i>
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete_single_lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete lead') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form role="form" id="deleteLeadForm">
                    <div class="modal-body">
                        <p>{{ __('Are you sur to delete this lead') }}</p>
                    </div>
                    <input type="hidden" id="lead_id_delete">
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete_mass_lead_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete lead') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form role="form" id="deleteMassLeadForm">
                    <div class="modal-body">
                        <p>{{ __('Are you sur to delete this lead') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Mass Share Lead Modal -->
    <div class="modal fade" id="massShareLeadModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Mass share lead') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="massShareForm">
                    @csrf
                    <div class="modal-body p-b-0">
                        <div class="form-group">
                            <select class="js-example-placeholder-multiple form-control" name="share_mass_lead[]"
                                    id="share_mass_lead"
                                    multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }} <i class="icon-save"></i>
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Mass Share Lead Modal -->
@endsection
