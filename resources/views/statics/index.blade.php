@extends('layouts.app')

@push('style')
<!-- Date-time picker css -->
<link rel="stylesheet" type="text/css"
  href="{{ asset('assets/pages/advance-elements/css/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
@endpush

@section('content')

<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Statistic</h4>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">List</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page header end -->
    <!-- Page body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-sm-12">
          <!-- Zero config.table start -->
          @include('partials.flash-message')
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col">
                      <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date">
                    </div>
                    <div class="col">
                      <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date">
                    </div>
                    <div class="col">
                      <button type="button" name="filter" id="filter" class="btn btn-primary">
                        Filter
                      </button>
                      <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh
                      </button>
                    </div>
                  </div>
                </div>
                @can('source-create1')
                <div class="col-lx-8">
                  <div class="f-right">
                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#sign-in-modal">Filter <i
                        class="ti-plus"></i>
                    </button>
                  </div>
                </div>
                @endcan
              </div>
            </div>
            <div class="card-block">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="order_table" style="width:100%">
                  <thead>
                    <tr>
                      <th>Employee name</th>
                      <th>New lead received today</th>
                      <th>Active clients</th>
                      <th>Not interested client</th>
                      <th>Tasks made</th>
                      <th>Note</th>
                      <th>Appointment</th>
                      <th>Sell</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="card-footer">

            </div>
          </div>
        </div>
        <!-- Zero config.table end -->
      </div>
    </div>
  </div>
  <!-- Page body end -->
</div>

@endsection
@push('scripts')
<!-- Bootstrap date-time-picker js -->
<script type="text/javascript" src="{{ asset('assets/pages/advance-elements/moment-with-locales.min.js') }}"></script>
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


<script>
        $('.input-daterange input').each(function () {
            $(this).datepicker();
        });
        $('#sandbox-container .input-daterange').datepicker({
            todayHighlight: true
        });
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $(document).ready(function () {
            function load_data(from_date = '', to_date = '') {
                $('#order_table').DataTable({
                    processing: true,
                    serverSide: true,
                    dom: 'Bfrtip',
                    ajax: {
                        url: '{{ route("static.index") }}',
                        data: {from_date: from_date, to_date: to_date},
                    },
                    @can('can-generate-report')
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    @endcan
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'new_leads_count', name: 'leads.new_leads_count'},
                        {data: 'new_clients_count', name: 'clients.new_clients_count'},
                        {data: 'not_interested_clients_count', name: 'clients.not_interested_clients_count'},
                        {data: 'archive_tasks_count', name: 'tasks.archive_tasks_count'},
                        {data: 'notes_count', name: 'notes.notes_count'},
                        {data: 'events_count', name: 'events.events_count'},
                        {data: 'invoices_count', name: 'invoices.invoices_count'},
                    ]
                });
            }
            // Submit form filter
            $('#filter').click(function () {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date !== '' && to_date !=='') {
                    $('#order_table').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Both Date is required');
                }
            });
            // Click on form refresh
            $('#refresh').click(function () {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#order_table').DataTable().destroy();
                load_data();
            });
            load_data();
            window.setInterval(load_data, 1800000);
        });
</script>
@endpush