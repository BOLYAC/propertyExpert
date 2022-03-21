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
    </script>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">Simple Dashboard</li>
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

        <div class="row col-8 col-auto">
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

        <div class="col-xl-6 xl-100 box-col-12">
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
    </div>
@endsection


