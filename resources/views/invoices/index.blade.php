@extends('layouts.vertical.master')
@section('title', '| Invoices')

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
            // Start Edit record
            let table = $('#res-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('invoices.data') }}',
                    data: function (d) {
                        d.stage = $('select[name=status_filter]').val();
                        d.user = $('select[name=user_filter]').val();
                        d.department = $('select[name=department_filter]').val();
                        d.team = $('select[name=team_filter]').val();
                        d.project = $('select[name=project_filter]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'lead_name', name: 'lead_name'},
                    {data: 'project_name', name: 'project_name'},
                    {data: 'user', name: 'user'},
                    {data: 'sells_name', name: 'sells_name'},
                    {data: 'action', name: 'action'},
                ],
                order: [],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
            // Filtration
            $('#refresh').click(function () {
                $('select[name=user_filter]').val('');
                $('select[name=department_filter]').val('');
                $('select[name=team_filter]').val('');
                $('select[name=project_filter]').val('');
                table.DataTable().destroy();
            });
            // Search form
            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                table.draw();
            });
            @can('lead-invoice')
            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                let data = table.row($tr).data();
                $('#deleteForm').attr('action', 'invoices/' + data[0]);
                $('#deleteModal').modal('show');
            })
            @endcan
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Invoices') }}</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">{{ __('Filter deal by:') }}</h6>
                    </div>
                    <form id="search-form">
                        <div class="card-body p-2">
                            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasPermissionTo('team-manager'))
                                <div class="form-group mb-2">
                                    <select name="user_filter" id="user_filter"
                                            class="custom-select custom-select-sm">
                                        <option value="">{{ __('Assigned') }}</option>
                                        @foreach($users as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(isset($departments))
                                    <div class="form-group mb-2">
                                        <select name="department_filter" id="department_filter"
                                                class="custom-select custom-select-sm">
                                            <option value="">{{ __('Department') }}</option>
                                            @foreach($departments as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if(isset($teams))
                                    <div class="form-group mb-2">
                                        <select name="team_filter" id="team_filter"
                                                class="custom-select custom-select-sm">
                                            <option value="">{{ __('Team') }}</option>
                                            @foreach($teams as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endif
                            <div class="form-group mb-2">
                                <select name="project_filter" id="project_filter"
                                        class="custom-select custom-select-sm">
                                    <option value="">{{ __('Project') }}</option>
                                    @foreach($projects as $row)
                                        <option value="{{ $row->id }}">{{ $row->project_name }}</option>
                                    @endforeach
                                </select>
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
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card b-t-primary">
                    @can('order-create')
                        <div class="card-header b-t-primary p-2">
                            <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">{{ __('New
                                Invoice') }}<i class="icon-plus"></i></a>
                        </div>
                    @endcan
                    <div class="card-body p-2">
                        <div class="order-history dt-ext table-responsive">
                            <table id="res-config" class="table table-striped display table-bordered nowrap"
                                   width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Client') }}</th>
                                    <th>{{ __('Project') }}</th>
                                    <th>{{ __('Assigned') }}</th>
                                    <th>{{ __('Sell representative') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>

@endsection

