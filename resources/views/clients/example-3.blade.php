@extends('layouts.app')
@push('style')
<!-- DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<!-- Notification.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/notification/notification.css') }}">
<style>
  .dt-head-center {
    text-align: center;
    vertical-align: middle !important;
  }

  table.dataTable thead .sorting::after,
  table.dataTable thead .sorting_asc::after,
  table.dataTable thead .sorting_desc::after {
    display: none;
  }

  table.dataTable thead .sorting::before,
  table.dataTable thead .sorting_asc::before,
  table.dataTable thead .sorting_desc::before {
    display: none;
  }

  table.dataTable thead .sorting {
    background-image: url(https://datatables.net/media/images/sort_both.png);
    background-repeat: no-repeat;
    background-position: center right;
  }

  table.dataTable thead .sorting_asc {
    background-image: url(https://datatables.net/media/images/sort_asc.png);
    background-repeat: no-repeat;
    background-position: center right;
  }

  table.dataTable thead .sorting_desc {
    background-image: url(https://datatables.net/media/images/sort_desc.png);
    background-repeat: no-repeat;
    background-position: center right;
  }
</style>
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
        <div class="col-sm-12">
          <!-- Zero config.table start -->
          @include('partials.flash-message')
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-12 mt-4">
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
                    @elseif(auth()->user()->hasRole('Manager'))
                    @if(auth()->user()->ownedTeams()->count() > 0)
                    <div class="col-sm">
                      <select name="user_filter1" id="user_filter1" class="form-control form-control-sm mt-1">
                        <option value="">Assigned</option>
                        @foreach(auth()->user()->currentTeam->allUsers() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    @endif

                    @endif
                    <div class="col">
                      <button type="button" name="filter" id="filter" class="btn btn-primary btn-sm">
                        Filter
                      </button>
                      <button type="button" name="refresh" id="refresh" class="btn btn-default btn-sm">Refresh
                      </button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="card-block">
              @can('share-client')
              <button type="button" id="row-select-btn" class="btn btn-sm btn-primary m-b-20">
                Assign
                Client
              </button>
              <button type="button" id="row-desselect-btn" class="btn btn-sm btn-primary m-b-20">
                Deselect all
              </button>
              <button type="button" id="row-send-btn" class="btn btn-sm btn-primary m-b-20">
                Send project
              </button>
              @endcan
              @can('client-import')
              <a class="btn btn-sm btn-outline-success m-b-20 float-right ml-2"
                href="{{ route('importExport') }}">Import
                data <i class="ti-upload"></i></a>
              @endcan

              @can('client-create')
              <a href="{{ route('clients.create') }}" class="btn btn-sm btn-outline-primary m-b-20 float-right">New
                client <i class="ti-plus"></i></a>
              @endcan
              <div class="dt-responsive table-responsive">
                <table id="simpletable" class="table task-list-table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th></th>
                      <th>N°</th>
                      <th>New</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>E-mail</th>
                      <th>Country</th>
                      <th>
                        <select name="status_filter" id="status_filter" class="custom-select custom-select-lg">
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
                      </th>
                      <th>
                        <select name="source_filter" id="source_filter" class="custom-select custom-select-lg">
                          <option value="">Source</option>
                          @foreach($sources as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                      </th>
                      <th>
                        <select name="priority_filter" id="priority_filter" class="custom-select custom-select-lg">
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
                      </th>
                      <th>
                        @if(auth()->user()->hasRole('Admin'))
                        <select name="user_filter" id="user_filter" class="custom-select custom-select-lg">
                          <option value="">Assigned</option>
                          @foreach($users as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                        @elseif(auth()->user()->hasRole('Manager'))
                        @if(auth()->user()->ownedTeams()->count() > 0)
                        <select name="user_filter" id="user_filter" class="custom-select custom-select-lg">
                          <option value="">Assigned</option>
                          @foreach(auth()->user()->currentTeam->allUsers() as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                          @endforeach
                        </select>
                        @else
                        Assigned
                        @endif
                        @else
                        Assigned
                        @endif
                      </th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="task-page">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Zero config.table end -->
      </div>
    </div>
  </div>
  <!-- Page body end -->
</div>
<!-- Edit modal start -->
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
<!-- Edit modal end -->
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
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/notification/notification.js') }}"></script>
<script>
  $(document).ready(function () {
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

            // Assign record
            function fetch_data() {
                let source = $('[name="source_filter"]').val();
                let user = $('[name="user_filter"]').val();
                let status = $('[name="status_filter"]').val();
                let priority = $('[name="priority_filter"]').val();
                let country = $('[name="country"]').val();
                let client_number = $('[name="client_number"]').val();
                let table = $('#simpletable').DataTable({
                    destroy: true,
                    order: [[0, 'asc']],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{!! route('clients.data') !!}',
                        data: {
                            user_id: user,
                            source_id: source,
                            status: status,
                            priority: priority,
                            country: country,
                            client_number
                        }
                    },
                    columns: [
                        {
                            data: 'id',
                            name: 'id',
                            visible: false
                        },
                        {
                            data: 'check',
                            name: 'check',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'public_id',
                            name: 'public_id'
                        },
                        {
                            data: 'type',
                            name: 'type',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'full_name',
                            name: 'full_name'
                        },
                        {
                            data: 'client_number',
                            name: 'client_number'
                        },
                        {
                            data: 'client_email',
                            name: 'client_email'
                        },
                        {
                            data: 'country',
                            name: 'country'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'source_id',
                            name: 'source_id',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'priority',
                            name: 'priority',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'user_id',
                            name: 'user_id',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                        },
                    ],
                    columnDefs: [
                        // Center align the header content of column 1
                        {
                            className: "dt-head-center",
                            targets: [0, 1, 2, 3, 4, 5, 6, 7, 11]
                        }
                    ],
                });

                @can('share-client')
                table.on('click', '.assign', function () {
                    let $tr = $(this).closest('tr');
                    if ($($tr).hasClass('child')) {
                        $tr = $tr.prev('.parent');
                    }
                    let data = table.row($tr).id()
                    $('#client_id').val(data);
                    $('#assignModal').modal('show');
                });
                @endcan
                // Submit Assignment
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
                ///////// Select all
                $('#row-select-btn').on('click', function (e) {
                    e.preventDefault();
                    let filter = [];
                    $('.checkbox-circle:checked').each(function () {
                        filter.push($(this).val());
                    });
                    if (filter.length > 0) {
                        $('#massAssignModal').modal('show');
                    } else {
                        notify('At least select one client!', 'danger');
                    }
                });
                ///////// Deselect all
                $('#row-desselect-btn').on('click', function (e) {
                    e.preventDefault();
                    $('.checkbox-circle:checked').each(function () {
                        table.ajax.reload(null, false);
                    });
                    if (filter.length > 0) {
                        notify('There is more that are selected', 'danger');
                    } else {
                        notify('All the row are not selected!', 'success');
                    }
                });
                // Mass assign
                $('#massAssignForm').on('submit', function (e) {
                    e.preventDefault();
                    let ids = [];
                    $('.checkbox-circle:checked').each(function () {
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
                // Send projects
                /* The code go here



                 */

            }

            $('#user_filter').change(function () {
                fetch_data();
            });
            $('#source_filter').change(function () {
                fetch_data();
            });
            $('#status_filter').change(function () {
                fetch_data();
            });
            $('#priority_filter').change(function () {
                fetch_data();
            });
            $('#filter').click(function () {
                $('[name="user_filter"]').val($('#user_filter1').val())
                $('[name="source_filter"]').val($('#source_filter1').val());
                $('[name="status_filter"]').val($('#status_filter1').val());
                $('[name="priority_filter"]').val($('#priority_filter1').val());
                fetch_data();
            });

            $('#refresh').click(function () {
                $('#user_filter1').val('')
                $('#source_filter1').val('')
                $('#status_filter1').val('')
                $('#priority_filter1').val('')
                $('#country').val('')
                $('#client_number').val('')
                $('[name="user_filter"]').val($('#user_filter1').val())
                $('[name="source_filter"]').val($('#source_filter1').val());
                $('[name="status_filter"]').val($('#status_filter1').val());
                $('[name="priority_filter"]').val($('#priority_filter1').val());
                $('#simpletable').DataTable().destroy();
                fetch_data();
            });
            fetch_data();
            window.setInterval(fetch_data, 1800000);
        });
</script>
@endpush