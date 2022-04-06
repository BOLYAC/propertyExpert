@extends('layouts.vertical.master')
@section('title', 'Dashboard')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/prism.css') }}">
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
    <script src="{{ asset('assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('#lead-table').DataTable({
                order: [[0, 'asc']],
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{!! route('dashboard.data') !!}',
                columns: [
                    {data: 'created_at', name: 'created_at',},
                    {data: 'full_name', name: 'full_name',},
                    {data: 'country', name: 'country'},
                    {data: 'nationality', name: 'nationality'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'priority', name: 'priority', orderable: false, searchable: false}
                ],
            });
            $('#agency-table').DataTable({
                order: [[0, 'desc']],
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{!! route('dashboard.agencies.data') !!}',
                columns: [
                    {data: 'created_at', name: 'created_at',},
                    {data: 'company_type', name: 'company_type',},
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                ],
            });
            $('#today-table').DataTable({
                order: [[4, 'desc']],
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{!! route('dashboard.task_today') !!}',
                columns: [
                    {data: 'source_type', name: 'source_type',},
                    {data: 'title', name: 'title',},
                    {data: 'name', name: 'name',},
                    {data: 'country', name: 'country', orderable: false},
                    {data: 'nationality', name: 'nationality', orderable: false},
                    {data: 'date', name: 'date'},
                ],
            });
            $('#tomorrow-table').DataTable({
                order: [[4, 'desc']],
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{!! route('dashboard.task_tomorrow') !!}',
                columns: [
                    {data: 'source_type', name: 'source_type'},
                    {data: 'title', name: 'title',},
                    {data: 'name', name: 'name',},
                    {data: 'country', name: 'country', orderable: false},
                    {data: 'nationality', name: 'nationality', orderable: false},
                    {data: 'date', name: 'date'},
                ],
            });
            $('#pending-table').DataTable({
                order: [[4, 'desc']],
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{!! route('dashboard.task_pending') !!}',
                columns: [
                    {data: 'source_type', name: 'source_type'},
                    {data: 'title', name: 'title',},
                    {data: 'name', name: 'name',},
                    {data: 'country', name: 'client.country', orderable: false},
                    {data: 'nationality', name: 'client.nationality', orderable: false},
                    {data: 'date', name: 'date'},
                ],
            });
            $('#completed-table').DataTable({
                order: [[4, 'desc']],
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{!! route('dashboard.task_completed') !!}',
                columns: [
                    {data: 'checked', name: 'checked',},
                    {data: 'source_type', name: 'source_type'},
                    {data: 'title', name: 'title',},
                    {data: 'name', name: 'name',},
                    {data: 'country', name: 'client.country', orderable: false},
                    {data: 'nationality', name: 'client.nationality', orderable: false},
                    {data: 'date', name: 'date'},
                    {data: 'updated_at', name: 'updated_at'},
                ],
            });
            let salesTable = $('#basic-1').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                info: false,
                searching: false,
                ajax: {
                    url: '{{ route('api.sales_performance_dates') }}',
                    data: function (d) {
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'tasks_made', name: 'tasks_made'},
                    {data: 'tasks_done', name: 'tasks_done'},
                    {data: 'notes_made', name: 'notes_made'},
                ]
            });
            // Refresh dates input
            $('#refresh').click(function () {
                $('input[name=from_date]').val('{{ now()->format('Y-m-d') }}')
                $('input[name=to_date]').val('{{ now()->format('Y-m-d') }}')
            });
            // Submit form for dates
            $('#search-form').on('submit', function (e) {
                let from_date = $('input[name=from_date]').val();
                let to_date = $('input[name=to_date]').val();
                if (from_date !== '' && to_date !== '') {
                    salesTable.draw();
                    e.preventDefault();
                } else {
                    alert('Both Date is required');
                    e.preventDefault();
                }
            });
        })
        ;
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
@endsection

@section('breadcrumb-title')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 xl-100 box-col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="project-overview">
                            <div class="row">
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-primary">{{ $allClients }}</h2>
                                    <p class="mb-0">{{ __('Total leads') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-secondary">{{ $olderTask }}</h2>
                                    <p class="mb-0">{{ __('Past tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-success">{{ $completedTasks }}</h2>
                                    <p class="mb-0">{{ __('Completed tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-info">{{ $todayTasks }}</h2>
                                    <p class="mb-0">{{ __('Today tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-danger">{{ $tomorrowTasks }}</h2>
                                    <p class="mb-0">{{ __('Tomorrow tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-warning">{{ $events }}</h2>
                                    <p class="mb-0"><a
                                            href="{{ route('events.index', 'today-event') }}">{{ __('Today Appointment(s)') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 xl-100 box-col-12 row">
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('clients.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="anchor"></i> Leads</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('tasks.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="check-square"></i> Tasks</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('events.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="calendar"></i> Calender</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('leads.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="tag"></i> Deals</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Cod Box Copy begin -->
        <div class="col-xl-12 xl-100 box-col-12">
            <div class="card">
                <div class="card-header">
                    <form method="post" id="search-form" role="form">
                        @csrf
                        <div class="row">
                            <div class="col mr-1 mr-1">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="example-daterange1">Performance</label>
                                    <div class="col-md-7">
                                        <div class="input-daterange input-group"
                                             data-date-format="yyyy-mm-dd"
                                             data-week-start="1" data-autoclose="true"
                                             data-today-highlight="true">
                                            <input type="date" class="form-control"
                                                   id="example-daterange1"
                                                   name="from_date" placeholder="From"
                                                   data-week-start="1"
                                                   data-autoclose="true" data-today-highlight="true">
                                            <div class="input-group-prepend input-group-append">
                                                <span class="input-group-text font-w600">to</span>
                                            </div>
                                            <input type="date" class="form-control"
                                                   id="example-daterange2"
                                                   name="to_date" placeholder="To"
                                                   data-week-start="1"
                                                   data-autoclose="true" data-today-highlight="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 pl-1 ml-1">
                                <div class="btn-group " role="group">
                                    <button type="submit" name="filter" id="filter"
                                            class="btn btn-success btn-sm">
                                        {{ __('Filter') }}
                                    </button>
                                    <button type="button" name="refresh" id="refresh"
                                            class="btn btn-dark btn-sm">
                                        {{ __('Refresh') }} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="dt-ext table-responsive product-table">
                        <table id="basic-1"
                               class="table table-striped display table-bordered nowrap">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Tasks made</th>
                                <th scope="col">Task done</th>
                                <th scope="col">Notes</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Cod Box Copy end -->
        <div class="col-xl-12 xl-100">
            <div class="card b-t-primary">
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-lead-tab" data-toggle="tab"
                                                href="#top-lead" role="tab" aria-controls="top-lead"
                                                aria-selected="true">{{ __('New lead') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="today-top-tab" data-toggle="tab"
                                                href="#top-today" role="tab" aria-controls="top-today"
                                                aria-selected="false">{{ __('Today tasks') }}</a></li>
                        <li class="nav-item"><a class="nav-link" id="tomorrow-top-tab" data-toggle="tab"
                                                href="#top-tomorrow" role="tab" aria-controls="top-tomorrow"
                                                aria-selected="false">{{ __('Tomorrow tasks') }}</a></li>
                        <li class="nav-item"><a class="nav-link" id="pending-top-tab" data-toggle="tab"
                                                href="#top-pending" role="tab" aria-controls="top-pending"
                                                aria-selected="false">{{ __('Pending tasks') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="completed-top-tab" data-toggle="tab"
                                                href="#top-completed" role="tab" aria-controls="top-completed"
                                                aria-selected="false">{{ __('Completed Tasks') }}</a></li>
                    </ul>
                    <div class="tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-lead" role="tabpanel"
                             aria-labelledby="top-lead-tab">
                            <div class="order-history dt-ext table-responsive">
                                <table class="display" id="lead-table">
                                    <thead>
                                    <tr>
                                        <th data-priority="1">{{ __('Created') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Nationality') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Priority') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="top-agency" role="tabpanel"
                             aria-labelledby="top-agency-tab">
                            @if(auth()->id() === 95 || auth()->id() === 116  || auth()->id() === 8)
                                <div class="order-history dt-ext table-responsive">
                                    <table class="display" id="agency-table">
                                        <thead>
                                        <tr>
                                            <th data-priority="1">{{ __('Create at') }}</th>
                                            <th>{{ __('Agency type') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-5 mx-auto">
                                        <div class="alert alert-primary outline alert-dismissible fade show"
                                             role="alert"><i data-feather="clock"></i>
                                            <p>No agencies for now</p>
                                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="top-today" role="tabpanel" aria-labelledby="profile-top-tab">
                            <div class="dt-ext table-responsive">
                                <table class="display" id="today-table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Client name') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Nationality') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-tomorrow" role="tabpanel" aria-labelledby="tomorrow-top-tab">
                            <div class="dt-ext table-responsive">
                                <table class="display" id="tomorrow-table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Client name') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Nationality') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-pending" role="tabpanel" aria-labelledby="tomorrow-top-tab">
                            <div class="dt-ext table-responsive">
                                <table class="display" id="pending-table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Client name') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Nationality') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-completed" role="tabpanel"
                             aria-labelledby="completed-top-tab">
                            <div class="users-total table-responsive">
                                <table class="table" id="completed-table">
                                    <thead>
                                    <tr>
                                        <th width="5%">{{ __('Stat') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Client') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Nationality') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Completed at') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
