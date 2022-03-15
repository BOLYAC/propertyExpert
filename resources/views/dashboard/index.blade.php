@extends('layouts.vertical.master')
@section('title', 'Dashboard')

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
        });
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
        <div class="col-xl-12 xl-100">
            <div class="card b-t-primary">
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-lead-tab" data-toggle="tab"
                                                href="#top-lead" role="tab" aria-controls="top-lead"
                                                aria-selected="true">{{ __('New lead') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="top-agency-tab" data-toggle="tab"
                                                href="#top-agency" role="tab" aria-controls="top-agency"
                                                aria-selected="true">{{ __('Agencies') }}</a>
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
