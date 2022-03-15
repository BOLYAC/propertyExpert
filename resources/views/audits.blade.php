@extends('layouts.vertical.master')
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
    <script type="text/javascript">
        $('#res-config').DataTable({
            processing: true,
            responsive: true,
            ajax: '{{ route('audits.list') }}',
            columns: [
                {data: 'auditable_type', name: 'auditable_type'},
                {data: 'event', name: 'event'},
                {data: 'username', name: 'username'},
                {data: 'created_at', name: 'created_at',searchable: false},
                {data: 'old_values', name:'old_values',orderable: false, searchable: false},
                {data: 'new_values', name:'new_values',orderable: false, searchable: false}
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">                
                <div class="card">
                    <div class="card-header">
                        
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="res-config" class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Model</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Old Values</th>
                                        <th scope="col">New Values</th>
                                    </tr>
                                    </thead>
                                    <tbody id="audits">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection
