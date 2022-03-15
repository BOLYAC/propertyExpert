@extends('layouts.vertical.master')
@section('title', 'User show')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
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
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('assets/js/Chart.js') }}"></script>
    <script>
        $(function () {
            /*Doughnut chart*/
            var ctx = document.getElementById("myChart");
            var data = {
                labels: [
                    "Tasks", "Leads", "Appointments", "Deals"
                ],
                datasets: [{
                    data: ['{{ $task_statistics }}', '{{ $lead_statistics }}', '{{ $event_statistics }}', '{{ $client_statistics }}'],
                    backgroundColor: [
                        "#1ABC9C",
                        "#FCC9BA",
                        "#B8EDF0",
                        "#B4C1D7"
                    ],
                    borderWidth: [
                        "0px",
                        "0px",
                        "0px",
                        "0px"
                    ],
                    borderColor: [
                        "#1ABC9C",
                        "#FCC9BA",
                        "#B8EDF0",
                        "#B4C1D7"

                    ]
                }]
            };

            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data
            });
        });

        let tasksTable = $('#tasks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('users.taskdata', ['id' => $user->id]) !!}',
                data: function (d) {
                    d.from_date = $('input[name=from_date]').val(),
                        d.to_date = $('input[name=to_date]').val(),
                        d.stat = $('[name="status_task"]').val()
                }
            },
            columns: [
                {data: 'title', name: 'title'},
                {data: 'client', name: 'client', orderable: false},
                {data: 'date', name: 'date'},
                {data: 'archive', name: 'archive', orderable: false, searchable: false}
            ]
        });

        let leadTable = $('#clients-table').DataTable({
            autoWidth: false,
            destroy: true,
            stateSave: false,
            order: [[0, 'asc']],
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('users.clientdata', ['id' => $user->id]) !!}',
                data: function (d) {
                    d.from_date = $('input[name=from_date]').val(),
                        d.to_date = $('input[name=to_date]').val(),
                        d.stat = $('[name="status_lead"]').val()
                }
            },
            columns: [
                {data: 'public_id', name: 'public_id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
            ]
        });

        let dealTable = $('#leads-table').DataTable({
            autoWidth: false,
            destroy: true,
            stateSave: false,
            order: [[0, 'asc']],
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('users.leaddata', ['id' => $user->id]) !!}',
                data: function (d) {
                    d.from_date = $('input[name=from_date]').val(),
                        d.to_date = $('input[name=to_date]').val(),
                        d.stat = $('[name="status_deal"]').val()
                }
            },
            columns: [
                {data: 'full_name', name: 'full_name', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: 'stage_id', name: 'stage_id', orderable: false, searchable: false},
            ]
        });

        let apppointmentTable = $('#appointment-table').DataTable({
            autoWidth: false,
            destroy: true,
            stateSave: false,
            order: [[0, 'desc']],
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('users.appointmentdata', ['id' => $user->id]) !!}',
                data: function (d) {
                    d.from_date = $('input[name=from_date]').val(),
                        d.to_date = $('input[name=to_date]').val()
                }
            },
            columns: [
                {data: 'event_date', name: 'event_date'},
                {data: 'client_id', name: 'client_id', orderable: false, searchable: false},
                {data: 'place', name: 'place'},
            ]
        });


        $('#refresh').click(function () {
            $('#from_date').val('{{ now()->format('Y-m-d') }}')
            $('#to_date').val('{{ now()->format('Y-m-d') }}')
        });

        $('#search-form').on('submit', function (e) {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date !== '' && to_date !== '') {
                tasksTable.draw();
                leadTable.draw();
                dealTable.draw();
                apppointmentTable.draw();
                e.preventDefault();
            } else {
                alert('Both Date is required');
                e.preventDefault();
            }
        });

        $('#status-task').change(function () {
            tasksTable.draw();
        });

        $('#status-lead').change(function () {
            leadTable.draw();
        });

        $('#status-deal').change(function () {
            dealTable.draw();
        });

    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('User list') }}</a></li>
    <li class="breadcrumb-item">{{ __('User stat') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body b-t-primary">
                        <div class="row ">
                            <div class="col-md-4 text-center">
                                <img src="{{  asset('storage/' . auth()->user()->image_path) }}"
                                     class="img-60 rounded-circle"
                                     alt="User-Profile-Image">
                            </div>
                            <div class="col-md-8">
                                <ul>
                                    <li class="f-18 font-weight-bold">{{ $user->name }}</li>
                                    <li class="f-18 font-weight-bold text-purple">{{ $user->roles->first()->name }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card">
                    <div class="card-body b-t-primary">
                        <form method="post" id="search-form" role="form">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <input type="date" name="from_date" id="from_date"
                                           class="form-control form-control-sm"
                                           placeholder="From Date"  
                                           required>
                                </div>
                                <div class="col">
                                    <input type="date" name="to_date" id="to_date"
                                           class="form-control form-control-sm"
                                           placeholder="To Date" value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                <div class="col">
                                    <div class="btn-group " role="group">
                                        <button type="submit" name="filter" id="filter"
                                                class="btn btn-success btn-sm">{{ __('Filter') }}
                                        </button>
                                        <button type="button" name="refresh" id="refresh"
                                                class="btn btn-dark btn-sm">{{ __('Refresh') }}
                                            <i
                                                class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
        <!-- Tabination card start -->
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="card">
                    <div class="card-body b-t-primary">
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tasks" role="tab">
                                    {{ __('Tasks') }}
                                </a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#clients"
                                   role="tab">{{ __('Leads') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#leads" role="tab">{{ __('Deals') }}</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#appointments"
                                   role="tab">{{ __('Appointment') }}</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tasks" role="tabpanel">
                                <div class="order-history dt-ext table-responsive">
                                    <table class="table task-list-table table-striped table-bordered nowrap"
                                           style="width:100%"
                                           id="tasks-table">
                                        <thead>
                                        <th>
                                            {{ __('Title') }}
                                        </th>
                                        <th>
                                            {{ __('Client') }}
                                        </th>
                                        <th>
                                            {{ __('Date') }}
                                        </th>
                                        <th>
                                            <select name="status_task" id="status-task" class="table-status-input">
                                                <option value="" selected>{{ __('All') }}</option>
                                                <option value="1">{{ __('Done') }}</option>
                                                <option value="2">{{ __('Pending') }}</option>
                                            </select>
                                        </th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="leads" role="tabpanel">
                                <div class="order-history dt-ext table-responsive">
                                    <table class="table task-list-table table-striped table-bordered nowrap"
                                           style="width:100%"
                                           id="leads-table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('Client') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>
                                                <select name="status_deal" id="status-deal"
                                                        class="table-status-input">
                                                    <option selected disabled> -- {{ __('Stage') }} --
                                                    </option>
                                                    <option value="1">{{ __('In contact') }}</option>
                                                    <option value="2">{{ __('Appointment Set') }}</option>
                                                    <option value="3">{{ __('Follow up') }}</option>
                                                    <option value="4">{{ __('Reservation') }}</option>
                                                    <option value="5">{{ __('contract signed') }}</option>
                                                    <option value="6">{{ __('Down payment') }}</option>
                                                    <option value="7">{{ __('Developer invoice') }}</option>
                                                    <option value="8">{{ __('Won Deal') }}</option>
                                                    <option value="9">{{ __('Lost') }}
                                                    </option>
                                                </select>
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="clients" role="tabpanel">
                                <div class="order-history dt-ext table-responsive">
                                    <table class="table task-list-table table-striped table-bordered nowrap"
                                           style="width:100%"
                                           id="clients-table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Full name') }}</th>
                                            <th>
                                                <select name="status_lead" id="status-lead"
                                                        class="table-status-input">
                                                    <option selected disabled> -- {{ __('Lead status') }} --
                                                    </option>
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
                                                </select>
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="appointments" role="tabpanel">
                                <div class="order-history dt-ext table-responsive">
                                    <table class="table task-list-table table-striped table-bordered nowrap"
                                           style="width:100%"
                                           id="appointment-table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Client') }}</th>
                                            <th>{{ __('Place') }}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-header b-t-primary">
                        <h5>{{ __('Chart') }}</h5>
                        <span></span>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabination card end -->
    </div>

@endsection
