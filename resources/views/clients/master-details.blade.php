@extends('layouts.app')

@push('style')
<!-- DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<!-- Notification.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/notification/notification.css') }}">
@endpush
@section('content')
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Clients List</h4>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Clients</a>
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
        <div class="col-3">
          <div class="card">
            <div class="card-heaer">

            </div>
            <div class="card-block">
              <h4 class="sub-title">Sales performance</h4>
              <div class="form-radio">
                <form id="radioForm">
                  <div class="radio radiofill radio-inline">
                    <label>
                      <input type="radio" name="radio" value="today" checked="checked">
                      <i class="helper"></i>Today
                    </label>
                  </div>
                  <div class="radio radiofill radio-inline">
                    <label>
                      <input type="radio" name="radio" value="month">
                      <i class="helper"></i>This month
                    </label>
                  </div>
                  <div class="radio radiofill radio-inline">
                    <label>
                      <input type="radio" name="radio" value="year">
                      <i class="helper"></i>This year
                    </label>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table compact table-striped table-bordered nowrap" id="stats-table">
                    <thead>
                      <tr>
                        <th>Sales name</th>
                        <th>Calls</th>
                        <th>Speaks</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-9">
          <!-- Task list card start -->
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-12 mt-4">
                  <form method="post" id="search-form" role="form">
                    @csrf
                    <div class="form-group row">
                      <div class="col">
                        <select name="status_filter1" id="status_filter1" class="form-control form-control-sm mt-1">
                          <option value=""> Status
                          </option>
                          <option value="1">
                            New Lead
                          </option>
                          <option value="2">
                            In contact
                          </option>
                          <option value="3">
                            Potential
                            appointment
                          </option>
                          <option value="4">
                            Appointment
                            set
                          </option>
                          <option value="5">
                            Sold
                          </option>
                          <option value="6">
                            Sleeping
                            Client
                          </option>
                          <option value="7">
                            Not interested
                          </option>
                          <option value="8">
                            No Answer
                          </option>
                          <option value="9">
                            No Answer
                          </option>
                        </select>
                      </div>
                      <div class="col">
                        <select name="source_filter1" id="source_filter1" class="form-control form-control-sm mt-1">
                          <option value="">Source</option>
                          @foreach($sources as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col">
                        <select name="priority_filter1" id="priority_filter1" class="form-control form-control-sm mt-1">
                          <option value="">Priority
                          </option>
                          <option value="1">
                            Low
                          </option>
                          <option value="2">
                            Medium
                          </option>
                          <option value="3">
                            High
                          </option>
                        </select>
                      </div>
                      <div class="col">
                        <input type="text" name="country" id="country" class="form-control form-control-sm mt-1"
                          placeholder="Country">
                      </div>
                      <div class="col">
                        <input type="text" name="client_number" id="client_number"
                          class="form-control form-control-sm mt-1" placeholder="Phone">
                      </div>
                      @if(auth()->user()->hasRole('Admin'))
                      <div class="col-sm">
                        <select name="user_filter1" id="user_filter1" class="form-control form-control-sm mt-1">
                          <option value="">Assigned</option>
                          @foreach($users as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      @endif
                      <div class="col">
                        <button type="submit" name="filter" id="filter" class="btn btn-primary btn-sm">
                          Filter
                        </button>
                        <button type="button" name="refresh" id="refresh" class="btn btn-default btn-sm">Refresh
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-block task-list">
              <form action="{{ route('mass.update') }}" method="post">
                @csrf
                @can('share-client')
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-sm btn-primary m-b-20">
                    <input id="checkAll" type="checkbox" checked autocomplete="off"> Select / Unselect
                  </label>
                </div>
                <button type="button" id="row-select-btn" class="btn btn-sm btn-primary m-b-20">
                  Assign
                  Client
                </button>
                <button type="button" id="row-send-btn" class="btn btn-sm btn-primary m-b-20">
                  Send project
                </button>
                @endcan
                <button type="submit" class="btn btn-sm btn-outline-primary m-b-20 float-right ml-2">Save <i
                    class="fa fa-floppy-o"></i></button>
                @can('client-import')
                <a class="btn btn-sm btn-outline-success m-b-20 float-right ml-2"
                  href="{{ route('importExport') }}">Import
                  data <i class="ti-upload"></i></a>
                @endcan
                <div class="table-responsive">
                  <table class="table dt-responsive task-list-table table-striped table-bordered nowrap"
                    id="customers-table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Single assgine -->
<div class="modal fade" id="assignModal" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Assign user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="assignForm">
        @csrf
        <div class="modal-body p-b-0">
          <input type="hidden" name="client_id" id="client_id">
          <div class="form-group">
            <select class="form-control" name="assigned_user" id="assigned_user">
              <option value="" selected>-- Select client --</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save <i class="ti-save-alt"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Single assgine -->
<!-- Mass Assigne -->
<div class="modal fade" id="massAssignModal" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Assign to user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="massAssignForm">
        @csrf
        <div class="modal-body p-b-0">
          <div class="form-group">
            <select class="form-control" name="assigned_user_mass" id="assigned_user_mass">
              <option value="" selected>-- Select client --</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save <i class="ti-save-alt"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/notification/notification.js') }}"></script>

<script id="details-template" type="text/x-handlebars-template">
  @verbatim
  <div class="label label-info">Customer {{ full_name }}'s notes</div>
        <table class="table details-table" id="notes-{{id}}">
            <thead>
            <tr>  
                <th>title</th>
                <th>Note</th>
                <th>Made by</th>
                <th>Type</th>
                <th>Created at</th>
            </tr>
            </thead>
        </table>
        @endverbatim
    </script>

<script>
  // Init notification
  function notify(message, type) {
    $.growl({
        message: message
    }, {
        type: type,
        allow_dismiss: false,
        label: 'Cancel',
        className: 'btn-xs btn-inverse',
        placement: {
            from: 'top',
            align: 'right'
        },
        delay: 2500,
        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        },
        offset: {
            x: 30,
            y: 30
        }
    });
}
  var template = Handlebars.compile($("#details-template").html());
      var table_stats = $('#stats-table').DataTable({
          paging:   false,
          ordering: false,
          info:     false,
          searching: false,
          ajax: '{{ route('api.sales_performance') }}',
          columns: [
            { data: 'name', name: 'name' },
            { data: 'calls_count', name: 'calls_count' },
            { data: 'spoken_count', name: 'spoken_count' },
          ],
          order: [[1, 'asc']]
      });
      var table = $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url :'{{ route('api.master_details') }}',
          data: function(d){
            d.user = $('select[name=user_filter1]').val();
            d.source = $('select[name=source_filter1]').val();
            d.status = $('select[name=status_filter1]').val();
            d.priority = $('select[name=priority_filter1]').val();
            d.country = $('input[name=country]').val();
            d.phone = $('input[name=client_number]').val();
            }
        },
        "drawCallback": function( settings ) {
        var api = this.api();
        // Output the data for the visible rows to the browser's console
        $("#customers-table thead").remove();
        },
        columns: [
          {
            "className":      'details-control',
            "orderable":      false,
            "searchable":     false,
            "data":           null,
            "defaultContent": ''
          },
          { data: 'public_id', name: 'public_id' },
          { data: 'details', name: 'details' },
          { data: 'details_2', name: 'details_2' },
          { data: 'status', name: 'status' },
          { data: 'calls', name: 'calls' },
          { data: 'assigne', name: 'assigne' }
        ],
        order: [[1, 'asc']]
      });
      // Add event listener for opening and closing details
      $('#customers-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'notes-' + row.data().id;
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
          paging:   false,
          ordering: false,
          info:     false,
          searching: false,
          ajax: data.details_url,
          columns: [
            { data: 'title', name: 'title' },
            { data: 'body', name: 'body' },
            { data: 'user_id', name: 'user_id' },
            { data: 'tableName', name: 'tableName' },
            { data: 'created_at', name: 'created_at'}
          ]
        })
      }
      // Check/Uncheck ALl
      $('#checkAll').change(function(){
        if($(this).is(':checked')){
          $('input[name="update[]"]').prop('checked',true);
        }else{
          $('input[name="update[]"]').each(function(){
            $(this).prop('checked',false);
          });
        }
      });

    // Checkbox click
  $('input[name="update[]"]').click(function(){
    var total_checkboxes = $('input[name="update[]"]').length;
    var total_checkboxes_checked = $('input[name="update[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
       $('#checkAll').prop('checked',true);
    }else{
       $('#checkAll').prop('checked',false);
    }
  });
  $("#radioForm input[type='radio']").change(function () {
    const val = document.querySelector("input[name=radio]:checked").value;
  })
  //Assigne user
  @can('share-client')
  $('#customers-table tbody').on('click', '.assign', function () {
    var tr = $(this).closest('tr');
        var row = table.row(tr);
        var data = row.data().id;
        $('#client_id').val(data);
        $('#assignModal').modal('show');
    });
    @endcan
    // Submit Assignment
    $('#row-select-btn').on('click', function (e) {
        e.preventDefault();
        let filter = [];
        $('.mass-check').each(function () {
            filter.push($(this).val());
        });
        if (filter.length > 0) {
            $('#massAssignModal').modal('show');
        } else {
            notify('At least select one client!', 'danger');
        }
    });
    $('#assignForm').on('submit', function (e) {
        e.preventDefault();
        let user_id = $('#assigned_user').val();
        let client_id = $('#client_id').val();
        $.ajax({
            url: "{{route('sales.share')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                user_id: user_id,
                client_id: client_id,
            },
            success: function (response) {
                table.ajax.reload(null, false);
                $('.modal').modal('hide');
                notify('Client transferred', 'success');
            },
        });
    });

    // Mass assign
    $('#massAssignForm').on('submit', function (e) {
      e.preventDefault();
      let ids = [];
      $('.mass-check:checked').each(function () {
          ids.push($(this).val());
      });
      $.ajax({
          url: "{{ route('sales.share.mass') }}",
          type: "POST",
          data: {
              "_token": "{{ csrf_token() }}",
              user_id: $('#assigned_user_mass').val(),
              clients: ids,
          },
          success: function (response) {
              table.ajax.reload(null, false);
              $('#massAssignModal').modal('hide');
              notify('Client transferred', 'success');
          },
      });
  });
  
    $('#refresh').click(function () {
        $('#user_filter1').val('')
        $('#source_filter1').val('')
        $('#status_filter1').val('')
        $('#priority_filter1').val('')
        $('#country').val('')
        $('#phone').val('')
    });

    $('#search-form').on('submit', function(e) {
        table.draw();
        e.preventDefault();
    });
</script>
@endpush