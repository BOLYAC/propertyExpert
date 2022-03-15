@extends('layouts.vertical.master')
@section('title', '| Projects')
@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
    <script>
        let table = $('#datatable').DataTable();
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Project list') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <div class="card-header p-2 b-t-primary b-b-primary">
                        <a href="{{ route('projects.create') }}"
                           class="btn btn-sm btn-outline-success">{{ __('New project') }} <i class="icon-plus"></i></a>
                    </div>
                    <div class="card-body b-t-primary">
                        <div class="order-history dt-ext table-responsive">
                            <table id="datatable"
                                   class="table display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Location') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $key => $project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        <td>{{ $project->company_name }}</td>
                                        <td>{{ $project->type }}</td>
                                        <td>{{ $project->location }}</td>
                                        <td class="action-icon">
                                            <a href="{{ route('projects.edit', $project) }}"
                                               class="m-r-15 text-muted f-18"
                                            ><i class="icofont icofont-eye-alt"></i></a>
                                            <a href="#!" class="m-r-15 text-muted f-18 delete"><i
                                                    class="icofont icofont-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection
