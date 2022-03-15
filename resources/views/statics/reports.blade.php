@extends('layouts.vertical.master')
@section('title', '| Report')

@section('style')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- <script src="../assets/js/notify/notify-script.js" ></script> -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>

    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="badge badge-primary">Tasks list</div>
        <div class="row">
            <table class="table details-table col mx-auto" id="client-{{id}}">
                <thead>
                <tr>
                    <th>Full name</th>
                    <th>Task title</th>
                    <th>Date</th>
                </tr>
                </thead>
            </table>
        </div>
        @endverbatim
    </script>

    <script>
        var template = Handlebars.compile($("#details-template").html());
        var table = $('#customers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('static.index') }}',
                data: function (d) {
                    d.from_date = $('input[name=from_date]').val();
                    d.to_date = $('input[name=to_date]').val();
                }
            },
            @can('can-generate-report')
            dom: 'lfrtBip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            @endcan
            "drawCallback": function (settings) {
                var api = this.api();
                // Output the data for the visible rows to the browser's console
            },
            columns: [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "searchable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {data: 'name', name: 'name'},
                {data: 'new_leads_count', name: 'leads.new_leads_count'},
                {data: 'new_clients_count', name: 'clients.new_clients_count'},
                {data: 'not_interested_clients_count', name: 'clients.not_interested_clients_count'},
                {data: 'archive_tasks_count', name: 'tasks.archive_tasks_count'},
                {data: 'notes_count', name: 'notes.notes_count'},
                {data: 'events_count', name: 'events.events_count'},
                {data: 'invoices_count', name: 'invoices.invoices_count'},
                {data: 'clients_count', name: 'clients_count'},
            ],
            order: [[1, 'asc']],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
        // Add event listener for opening and closing details
        $('#customers-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var tableId = 'client-' + row.data().id;
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(template(row.data())).show();
                initTable(tableId, row.data());
                console.log(row.data());
                tr.addClass('shown');
                tr.next().find('td').addClass('no-padding bg-gray');
            }
        });

        function initTable(tableId, data) {
            $('#' + tableId).DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                ajax:
                    {
                        url: data.details_url,
                        data: function (d) {
                            d.from_date = $('input[name=from_date]').val();
                            d.to_date = $('input[name=to_date]').val();
                        }
                    },
                columns: [
                    {data: 'full_name', name: 'full_name'},
                    {data: 'title', name: 'title'},
                    {data: 'date', name: 'date'},
                ]
            })
        }

        //Assigne user
        $('#refresh').click(function () {
            $('#from_date').val('{{ now()->format('Y-m-d') }}')
            $('#to_date').val('{{ now()->format('Y-m-d') }}')
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
    <li class="breadcrumb-item">{{ __('Tasks list') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col mx-auto">
                <!-- Task list card start -->
                <div class="card">
                    <div class="card-header b-t-primary b-b-primary">
                        <div class="row">
                            <div class="col-12 mt-4">
                                <form method="post" id="search-form" role="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <input type="date" name="from_date" id="from_date"
                                                   class="form-control form-control-sm"
                                                   placeholder="From Date" value="{{ now()->format('Y-m-d') }}"
                                                   required>
                                        </div>
                                        <div class="col">
                                            <input type="date" name="to_date" id="to_date"
                                                   class="form-control form-control-sm"
                                                   placeholder="To Date" value="{{ now()->format('Y-m-d') }}"
                                                   required>
                                        </div>
                                        <div class="col">
                                            <div class="btn-group " role="group">
                                                <button type="submit" name="filter" id="filter"
                                                        class="btn btn-success btn-sm">
                                                    {{ __('Filter') }}
                                                </button>
                                                <button type="button" name="refresh" id="refresh"
                                                        class="btn btn-dark btn-sm">
                                                    {{ __('Refresh') }} <i
                                                        class="icofont icofont-refresh"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class=" dt-ext table-responsive">
                            <table
                                id="customers-table"
                                class="table table-striped table-bordered nowrap"
                                style="width:100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('Employee name') }}</th>
                                    <th>{{ __('New lead received') }}</th>
                                    <th>{{ __('Active clients') }}</th>
                                    <th>{{__('Not interested client')}}</th>
                                    <th>{{ __('Tasks made') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Appointment') }}</th>
                                    <th>{{ __('Sell') }}</th>
                                    <th>{{ __('All leads') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
