@extends('layouts.vertical.master')
@section('title', 'Tags list')

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
            let table = $('#datatable').DataTable();
            table.on('click', '.edit', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                $('#name').val(data[1]);
                $('#description').val(data[2]);
                $('#editForm #for_company').prop('checked', data[4]);
                $('#editForm').attr('action', '/tags/' + data[0]);
                $('#editModal').modal('show');
            })
            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#deleteForm').attr('action', '/tags/' + data[0]);
                $('#deleteModal').modal('show');
            })

        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Tags') }}</li>
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
                        @can('source-create')
                            <button class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#sign-in-modal">{{ __('New tag') }} <i class="icon-plus"></i>
                            </button>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive product-table">
                            <table id="datatable"
                                   class="table table-striped display table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th width="10%">N°</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="d-none"></th>
                                    <th width="10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tags as $key => $tag)
                                    <tr>
                                        <td>{{ $tag->id }}</td>
                                        <td>{{ $tag->name ?? '' }}</td>
                                        <td>{{ $tag->description ?? '' }}</td>
                                        <td>{{ $tag->status == 1 ? __('Yes') : __('No') }}</td>
                                        <td class="d-none">{{ $tag->status }}</td>
                                        <td>
                                            @can('tags-edit')
                                                <a href="#"
                                                   class="m-r-15 text-muted f-18 edit"><i
                                                        class="icofont icofont-eye-alt"></i></a>
                                            @endcan
                                            @can('tags-delete')
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

    <!-- Create modal start -->
    <div class="modal fade" id="sign-in-modal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('New tag') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-b-0">
                        <div class="form-group">
                            <label for="title">
                                {{ __('Title') }}
                            </label>
                            <input class="form-control" type="text" name="name"
                                   placeholder="Source title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" cols="10" rows="3"></textarea>
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
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit tag') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/tags" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-b-0">
                        <div class="form-group">
                            <label for="title">
                                {{ __('Title') }}
                            </label>
                            <input class="form-control" type="text" name="name" id="name"
                                   placeholder="Source title">
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-dark">
                                <input id="status" name="status" type="checkbox">
                                <label for="status">{{ __('Status') }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="description" cols="10"
                                      rows="3"></textarea>
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
    <!-- Edit modal end -->
    <!-- Edit modal start -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete tag')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/tags" method="POST" id="deleteForm">
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
