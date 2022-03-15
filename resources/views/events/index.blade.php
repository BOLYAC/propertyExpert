@extends('layouts.vertical.master')
@section('title', '| Appointments')

@section('style_before')
    <!-- Notification.css -->
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

    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/buttons.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.colReorder.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/datepicker/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('input[name=daterange]').val('')
            // Start Edit record
            let table = $('#res-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('events.data') }}',
                    data: function (d) {
                        d.stage = $('select[name=status_filter]').val();
                        d.user = $('select[name=user_filter]').val();
                        d.userRep = $('select[name=sell_rep_filter]').val();
                        d.department = $('select[name=department_filter]').val();
                        d.country = $('select[name=country_filter]').val();
                        d.team = $('select[name=team_filter]').val();
                        d.daterange = $('input[name=daterange]').val()
                        d.confirmed = $('#confirmed').is(':checked');
                        d.val = $("input[name=radio]:checked").val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'lead_name', name: 'lead_name'},
                    {data: 'event_date', name: 'event_date'},
                    {data: 'user', name: 'user'},
                    {data: 'sells_name', name: 'sells_name', 'searchable': false, 'orderable': false},
                    {data: 'confirmed', name: 'confirmed'},
                    {data: 'action', name: 'action'},
                ],
                order: [[3, 'desc']],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
            // Assigne user
            $('#refresh').click(function () {
                $('select[name=status_filter]').val('');
                $('select[name=user_filter]').val('');
                $('select[name=sell_rep_filter]').val('');
                $('select[name=department_filter]').val('');
                $('select[name=team_filter]').val('');
                $('input[name=daterange]').val('')
                $('input[type="radio"]').filter('[value=all]').prop('checked', true);
                $('#confirmed').prop('checked', false);
                table.DataTable().destroy();
            });
            // Search form
            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                table.draw();
            });

            @can('event-delete')
            table.on('click', '.delete', function () {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                let tableId = row.data().id;
                $('#deleteForm').attr('action', 'events/' + tableId);
                $('#deleteModal').modal('show');
            })
            @endcan
        });
    </script>

@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Appointments') }}</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">{{ __('Filter appointments by:') }}</h6>
                    </div>
                    <form id="search-form">
                        <div class="card-body p-2">
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
                            @if(isset($sellsRep))
                                <div class="form-group mb-2">
                                    <select name="sell_rep_filter" id="sell_rep_filter"
                                            class="custom-select custom-select-sm">
                                        <option value="">{{ __('Sell representative') }}</option>
                                        @foreach($sellsRep as $rep)
                                            <option
                                                value="{{ $rep->id }}">{{ $rep->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="checkbox checkbox-primary">
                                <input id="confirmed" type="checkbox">
                                <label for="confirmed">{{ __('Confirmed') }}</label>
                            </div>

                            <div class="form-group m-t-15 custom-radio-ml">
                                <div class="radio radio-primary">
                                    <input id="radio1" type="radio" name="radio" value="all" checked>
                                    <label for="radio1">{{ __('All') }}</label>
                                </div>
                                <div class="radio radio-primary">
                                    <input id="radio2" type="radio" name="radio" value="event-date">
                                    <label for="radio2">{{ __('Appointment') }}</label>
                                </div>
                                <div class="radio radio-primary">
                                    <input id="radio3" type="radio" name="radio" value="zoom-meeting">
                                    <label for="radio3">{{ __('Zoom meeting') }}</label>
                                </div>
                            </div>

                            <div class="theme-form mb-2">
                                <input class="form-control form-control-sm digits" type="text" name="daterange"
                                       value="">
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
                @include('partials.flash-message')
                <div class="card p-1">
                    <div class="card-header card-no-border p-2 b-t-primary b-b-primary">
                        @can('event-create')
                            <a href="{{ route('events.create') }}" class="btn btn-sm btn-outline-primary">
                                {{ __('New Appointment') }} <i class="icon-plus"></i></a>
                        @endcan
                        @can('can-generate-report')
                            <a href="{{ route('view.report', 'today') }}" class="btn btn-sm btn-outline-success">
                                {{ __('Generate report for today') }}
                                <i class="icon-calendar"></i>
                            </a>
                            <a href="{{ route('view.report', 'tomorrow') }}" class="btn btn-sm btn-outline-success">
                                {{ __('Generate report for the next day') }}
                                <i class="icon-calendar"></i>
                            </a>
                        @endcan
                        <a href="{{ route('calender.index') }}" class="btn btn-sm btn-outline-success pull-right">
                            {{ __('Calendar') }}
                            <i class="icon-calendar"></i></a>
                        <div class="col-12 mt-2">
                            <form action="{{ route('generate.custom.report') }}" method="post" role="form">
                                @csrf
                                <div class="row">
                                    <div class="col-3 pr-1 pl-0">
                                        <input type="date" name="from_date" id="from_date"
                                               class="form-control form-control-sm"
                                               placeholder="From Date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-3 pr-1 pl-1">
                                        <input type="date" name="to_date" id="to_date"
                                               class="form-control form-control-sm"
                                               placeholder="To Date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col pr-1 pl-1">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm">{{ __('Generate') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="order-history dt-ext table-responsive">
                            <table id="res-config"
                                   class="table task-list-table table-striped table-bordered nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Client') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Assigned') }}</th>
                                    <th>{{ __('Sell representative') }}</th>
                                    <th>{{ __('Confirmed') }}</th>
                                    <th width="5%"></th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete modal start -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete appointment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/events" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-b-0">
                        <p>{{ __('Are sur you want to delete this appointment?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Delete') }} <i class="ti-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete modal end -->

@endsection
