@extends('layouts.vertical.master')
@section('title', 'Report')

@section('style_before')
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/pages/advance-elements/css/bootstrap-datetimepicker.css') }}">
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection
@section('style')

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

    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="label label-info">Tasks list</div>
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
            dom: 'Bfrtip',
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
            lengthMenu: [15, 25, 50, 75, 100]
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

@section('breadcrumb-title')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col mx-auto">
                <!-- Task list card start -->
                <div class="card">
                    <div class="card-header">
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
                                                        class="btn btn-success btn-sm waves-effect waves-light">
                                                    Filter
                                                </button>
                                                <button type="button" name="refresh" id="refresh"
                                                        class="btn btn-inverse btn-sm waves-effect waves-light">
                                                    Refresh <i
                                                        class="icofont icofont-refresh"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-block task-list">
                        @csrf
                        <div class="table-responsive">
                            <table
                                class="table dt-responsive task-list-table table-striped table-bordered nowrap"
                                id="customers-table" style="width: 100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Employee name</th>
                                    <th>New lead received</th>
                                    <th>Active clients</th>
                                    <th>Not interested client</th>
                                    <th>Tasks made</th>
                                    <th>Note</th>
                                    <th>Appointment</th>
                                    <th>Sell</th>
                                    <th>All leads</th>
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
    </div>
    <!-- Single assgine -->

@endsection

@push('scripts')
    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript"
            src="{{ asset('assets/pages/advance-elements/moment-with-locales.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/advance-elements/bootstrap-datetimepicker.min.js') }}">
    </script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>


@endpush
