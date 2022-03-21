@extends('layouts.vertical.master')
@section('title', 'Marketing')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('style')

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
            var table = $('#datatable').DataTable();
            // Check/Uncheck ALl
            $('#checkAll').change(function () {
                if ($(this).is(':checked')) {
                    $('.checkbox-circle').prop('checked', true);
                } else {
                    $('.checkbox-circle').each(function () {
                        $(this).prop('checked', false);
                    });
                }
            });
            // Transfer leads
            $('#row-select-btn').on('click', function (e) {
                e.preventDefault();
                let filter = [];
                $('.checkbox-circle:checked').each(function () {
                    filter.push($(this).val());
                });
                if (filter.length > 0) {
                    $('#massAssignModal').modal('show');
                } else {
                    notify('At least select one lead!', 'danger');
                }
            });
            // Mass assign modal
            $('#massAssignForm').on('submit', function (e) {
                e.preventDefault();
                let ids = [];
                $('.checkbox-circle:checked').each(function () {
                    ids.push($(this).val());
                });
                $.ajax({
                    url: "{{ route('marketing.transfer') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        user_id: $('#assigned_user_mass').val(),
                        clients: ids,
                    },
                    success: function (response) {
                        tableNew.ajax.reload(null, false);
                        $('#massAssignModal').modal('hide');
                        notify('Lead transferred', 'success');
                    },
                });
            });
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Marketing') }}</li>
@endsection

@section('breadcrumb-title')

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <div class="card-header b-t-primary b-b-primary">
                        @can('marketing-import')
                            <button class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#sign-in-modal">{{ __('Import from Excel') }} <i
                                    class="icon-import"></i>
                            </button>
                        @endcan
                        <div class="btn-group btn-group-xs btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-primary btn-sm">
                                <input id="checkAll" type="checkbox" checked
                                       autocomplete="off">{{ __('Select/Unselect') }}
                            </label>
                        </div>
                        <button type="button" id="row-select-btn" class="btn btn-primary btn-sm">
                            {{ __('Transfer lead') }}
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive product-table">
                            <table id="datatable"
                                   class="table table-striped display table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th width="10%">N°</th>
                                    <th>{{ __('Lead name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone number') }}</th>
                                    <th>{{ __('Country') }}</th>
                                    <th>{{ __('Ad Name') }}</th>
                                    <th>{{ __('Adset Name') }}</th>
                                    <th>{{ __('Campaign name') }}</th>
                                    <th>{{ __('Form name') }}</th>
                                    <th>{{ __('Platform') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th width="10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($marketings as $key => $mark)
                                    <tr>
                                        <th><input type="checkbox" class="checkbox-circle check-task"
                                                   name="selected_row[]" value="{{ $mark->id }}"></th>
                                        <td>{{ $mark->id }}</td>
                                        <td>{{ $mark->lead_name ?? '' }}</td>
                                        <td>{{ $mark->email ?? '' }}</td>
                                        <td>{{ $mark->phone_number }}</td>
                                        <td>{{ $mark->country }}</td>
                                        <td>{{ $mark->ad_name }}</td>
                                        <td>{{ $mark->adset_name }}</td>
                                        <td>{{ $mark->campaign_name }}</td>
                                        <td>{{ $mark->form_name }}</td>
                                        <td>{{ $mark->platform }}</td>
                                        <td>{{ $mark->description }}</td>
                                        <td>
                                            @can('source-delete')
                                                <a href="#" class="m-r-15 text-muted f-18 delete"> <i
                                                        class="icofont icofont-trash"></i></a>
                                            @endcan
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
    <!-- Assign leads -->
    <div class="modal fade" id="massAssignModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Assign to user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="massAssignForm">
                    @csrf
                    <div class="modal-body p-b-0">
                        <div class="form-group">
                            <select class="form-control" name="assigned_user_mass" id="assigned_user_mass">
                                <option value="" selected>-- {{ __('Select user') }} --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }} <i class="icon-save"></i>
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Assign leads -->
    <!-- Create modal start -->
    <div class="modal fade" id="sign-in-modal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Import') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('marketing.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-b-0">
                        <div class="form-group">
                            <label for="source">{{ __('Source') }}</label>
                            <select class="form-control" name="source" id="source">
                                <option value="" selected>-- {{ __('Select source') }} --</option>
                                @foreach($sources as $source)
                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Upload File</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="file" data-original-title="" title="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }} <i class="ti-save-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Create modal end -->
    <!-- Edit modal start -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete source')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/sources" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-b-0">
                        <p>{{ __('Are sur you want to delete?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Delete') }} <i class="ti-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit modal end -->
@endsection
