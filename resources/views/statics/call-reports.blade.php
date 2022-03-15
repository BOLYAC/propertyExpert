@extends('layouts.vertical.master')
@section('title', '| Calls report')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')

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

    <script>
        let table = $('#customers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('calls.filter') }}',
                data: function (d) {
                    d.from_date = $('input[name=from_date]').val();
                    d.to_date = $('input[name=to_date]').val();
                    d.team = $('select[name=team]').val();
                }
            },
            @can('can-generate-report')
            dom: 'lfrtBip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            @endcan
            columns: [
                {data: 'name', name: 'name'},
                {data: 'new_upcoming', name: 'clients.new_upcoming'},
                {data: 'new_outgoing', name: 'clients.new_outgoing'},
            ],
            order: [[1, 'asc']],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });


        //refresh filter
        $('#refresh').click(function () {
            $('#from_date').val('{{ now()->format('Y-m-d') }}')
            $('#to_date').val('{{ now()->format('Y-m-d') }}')
            $('#team').val('')
        });

        $('#search-form').on('submit', function (e) {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date !== '' && to_date !== '') {
                table.draw();
                e.preventDefault();
            } else {
                alert('Both Date is required');
                e.preventDefault();
            }
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Calls report') }}</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col mx-auto">
                <!-- Task list card start -->
                <div class="card">
                    <div class="card-header p-4 b-t-primary b-b-primary">
                        <div class="row">
                            <div class="col-12">
                                <form method="post" id="search-form" role="form">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-6">
                                            <input type="date" name="from_date" id="from_date"
                                                   class="form-control form-control-sm"
                                                   placeholder="From Date" value="{{ now()->format('Y-m-d') }}"
                                                   required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <input type="date" name="to_date" id="to_date"
                                                   class="form-control form-control-sm"
                                                   placeholder="To Date" value="{{ now()->format('Y-m-d') }}"
                                                   required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <select class="custom-select custom-select-sm" name="team" id="team">
                                                <option value="">{{ __('Select team') }}</option>
                                                @foreach($teams as $team )
                                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6 text-right">
                                            <div class="btn-group " role="group">
                                                <button type="submit" name="filter" id="filter"
                                                        class="btn btn-success btn-sm">{{ __('Filter') }}</button>
                                                <button type="button" name="refresh" id="refresh"
                                                        class="btn btn-dark btn-sm">{{ __('Refresh') }}
                                                    <i
                                                        class="icofont icofont-refresh"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table
                                id="customers-table" class="table table-striped table-bordered nowrap"
                                style="width:100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Employee name') }}</th>
                                    <th>{{ __('Upcoming calls') }}</th>
                                    <th>{{ __('Outgoing calls') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single assgine -->

@endsection
