@extends('layouts.app')
@push('style')
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
              <form action="{{ route('mass.update') }}" method="post">
                @csrf
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
                <button type="submit" class="btn btn-sm btn-outline-primary m-b-20 float-right ml-2">Save <i
                    class="fa fa-floppy-o"></i></button>
                @can('client-create')
                <a href="{{ route('clients.create') }}"
                  class="btn btn-sm btn-outline-primary m-b-20 ml-2 float-right">New
                  client <i class="ti-plus"></i></a>
                @endcan
                @can('client-import')
                <a class="btn btn-sm btn-outline-success m-b-20 float-right ml-2"
                  href="{{ route('importExport') }}">Import
                  data <i class="ti-upload"></i></a>
                @endcan
                <div class=" dt-responsive table-responsive">
                  <table id="simpletable" class="table task-list-table table-striped table-bordered nowrap">
                    <thead>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </thead>
                    <tbody class="task-page">
                      @foreach($clients as $client)
                      <tr class="unread">
                        <td>
                          <a href="{{ route('clients.edit', $client->public_id) }}">{{ $client->public_id }}</a>
                        </td>
                        <td>
                          <span>Send Quota</span>
                          <p class="text-danger">{{ $client->client_email }}</p>
                          <p class="text-danger">
                            {{ $client->client_number }}
                            <br>
                            {{ $client->client_number_2 }}
                          </p>
                          <span>Originate Country</span>
                          <p class="text-bold">
                            <b>
                              {{ $client->country }}
                            </b>
                          </p>
                        </td>
                        <td>
                          <div class="row">
                            <div class="col">
                              <p>{{ $client->full_name }}</p>
                            </div>
                            <div class="col">
                              <a href="{{  route('clients.edit', $client) }}" class="btn btn-primary btn-sm">Sales
                                details
                              </a>
                            </div>
                          </div>
                          <div class="mx-auto">
                            <a class="btn btn-sm btn-default" style="color:black" href="#">
                              Show/Hide
                            </a>
                            <a class="btn btn-sm btn-danger" href="#">
                              Reallocate
                            </a>
                            <a class="btn btn-sm btn-warning" href="#" style="color:black">
                              To Cameron
                            </a>
                          </div>
                          <div class="row mt-2">
                            <div class="col-2">
                              <a class="btn btn-sm btn-danger" href="#" role="button">
                                Junk
                              </a>
                            </div>
                            <div class="col">
                              <label>
                                <input type="checkbox" name="call-{{ $client->id }}" class="m-2" autocomplete="off"
                                  {{ $client->called ? 'checked' : null }}>
                                Called
                              </label>
                              <label>
                                <input type="checkbox" name="speak-{{ $client->id }}" class="m-2" autocomplete="off"
                                  {{ $client->spoken ? 'checked' : null }}>
                                Spoken
                              </label>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm" style="margin-bottom:4px!important">
                            <label>Status</label>
                            <select name="source_id-{{ $client->id }}"
                              class="form-control @error('source_id') form-control-danger @enderror">
                              <option value="" selected disabled> Select source
                              </option>
                              @foreach($sources as $source)
                              <option value="{{ $source->id }}" {{ $client->source_id == $source->id ? 'selected' :
                              '' }}>{{ $source->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group form-group-sm" style="margin-bottom:4px!important">
                            <label for="status">Status</label>
                            <select name="status-{{ $client->id }}" class="form-control">
                              <option value="0" selected disabled> -- Client status
                                --
                              </option>
                              <option value="1" {{ $client->status == '1' ? 'selected' : '' }}>
                                New Lead
                              </option>
                              <option value="2" {{ $client->status == '2' ? 'selected' : '' }}>
                                In contact
                              </option>
                              <option value="3" {{ $client->status == '3' ? 'selected' : '' }}>
                                Potential
                                appointment
                              </option>
                              <option value="4" {{ $client->status == '4' ? 'selected' : '' }}>
                                Appointment
                                set
                              </option>
                              <option value="5" {{ $client->status == '5' ? 'selected' : '' }}>
                                Sold
                              </option>
                              <option value="6" {{ $client->status == '6' ? 'selected' : '' }}>
                                Sleeping
                                Client
                              </option>
                              <option value="7" {{ $client->status == '7' ? 'selected' : '' }}>
                                Not interested
                              </option>
                              <option value="8" {{ $client->status == '8' ? 'selected' : '' }}>
                                No Answer
                              </option>
                              <option value="9" {{ $client->status == '9' ? 'selected' : '' }}>
                                Wrong Number
                              </option>
                            </select>
                          </div>
                          <div class="form-group form-group-sm" style="margin-bottom:4px!important">
                            <label for="budget">Budget</label>
                            <select name="budget-{{ $client->id }}" class="form-control">
                              <option value="0" selected disabled> Select budget
                              </option>
                              <option value="1" {{ $client->budget == '1' ? 'selected' : '' }}>
                                Less then
                                50K
                              </option>
                              <option value="2" {{ $client->budget == '2' ? 'selected' : '' }}>
                                50K <> 100K
                              </option>
                              <option value="3" {{ $client->budget == '3' ? 'selected' : '' }}>
                                100K <>
                                  150K
                              </option>
                              <option value="4" {{ $client->budget == '4' ? 'selected' : '' }}>
                                150K <>
                                  200K
                              </option>
                              <option value="5" {{ $client->budget == '5' ? 'selected' : '' }}>
                                200K <>
                                  300K
                              </option>
                              <option value="6" {{ $client->budget == '6' ? 'selected' : '' }}>
                                300K <>
                                  400k
                              </option>
                              <option value="7" {{ $client->budget == '7' ? 'selected' : '' }}>
                                400k <>
                                  500K
                              </option>
                              <option value="8" {{ $client->budget == '8' ? 'selected' : '' }}>
                                500K <>
                                  600k
                              </option>
                              <option value="9" {{ $client->budget == '9' ? 'selected' : '' }}>
                                600K <> 1M
                              </option>
                              <option value="10" {{ $client->budget == '10' ? 'selected' : '' }}>
                                1M <> 2M
                              </option>
                              <option value="11" {{ $client->budget == '11' ? 'selected' : '' }}>
                                More then
                                2M
                              </option>
                            </select>
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <label>Next Call</label>
                            <input type="datetime-local" name="next_call-{{ $client->id }}"
                              class="form-control form-control-sm"
                              value="{{ $client->next_call ? Carbon\Carbon::parse($client->next_call)->format('Y-m-d\TH:i') : null }}"
                              placeholder="">
                          </div>
                          <p>
                            <b>Created at:</b>
                            <br>
                            <span
                              style="font:bold;">{{ Carbon\Carbon::parse($client->created_at)->format('Y-m-d H:i') }}</span>

                          </p>
                        </td>
                        <td>
                          <div class="form-group form-group-sm" style="margin-bottom:4px!important">
                            <label for="priority">Priority</label>
                            <select name="priority-{{ $client->id }}" class="form-control">
                              <option value="0" selected disabled> Priority
                              </option>
                              <option value="1" {{ $client->priority == '1' ? 'selected' : '' }}>
                                Low
                              </option>
                              <option value="2" {{ $client->priority == '2' ? 'selected' : '' }}>
                                Medium
                              </option>
                              <option value="3" {{ $client->priority == '3' ? 'selected' : '' }}>
                                High
                              </option>
                            </select>
                            <div class="form-group form-group-sm" style="margin-bottom:4px!important">
                              <label for="inCharge">Share with</label>
                              <select class="form-control" name="inCharge-{{ $client->id }}">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                              </select>
                              <label>
                                <input type="checkbox" class="m-2" name="update[]" value="{{ $client->id }}"
                                  autocomplete="off">
                                Apply changes
                              </label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    </tbody>
                  </table>
                </div>
              </form>
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

  let table = $('#simpletable').DataTable();

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

    console.log(total_checkboxes)
    console.log(total_checkboxes_checked)
  });
  });
</script>
@endpush