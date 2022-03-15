@extends('layouts.vertical.master')
@section('title', '| Users')

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

    <script>
        $(document).ready(function () {
            // Start Edit record
            let table = $('#res-config').DataTable();
            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#deleteForm').attr('action', 'users/' + data[0]);
                $('#deleteModal').modal('show');
            })
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Users list') }}</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <div class="card-header b-t-primary b-b-primary p-2">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-primary">
                            {{ __('New user') }}<i class="icon-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive product-table">
                            <table id="res-config"
                                   class="table table-striped display table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('E-mail') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Team') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-inline-block align-middle"><img
                                                    class="img-radius img-50 align-top m-r-15 rounded-circle"
                                                    src="{{  asset('storage/' . $user->image_path ?? 'users/16.png')}}"
                                                    alt="">
                                                <div class="d-inline-block"><h6
                                                        class="f-w-400">{{optional($user)->name}}</h6>
                                                    <span
                                                        class="f-w-400">{{ __('Last modify:') }} {{ $user->updated_at->format('Y/m/d') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <span>{{ $user->email ?? '' }}</span><br>
                                                    <span>{{ $user->phone_1 ?? '' }} - {{ $user->phone_2 ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success btn-xs">
                                            {{ $user->roles->first()->name ?? '' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-secondary btn-xs">
                                                {{ $user->department->name ?? '' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info btn-xs">
                                            {{ $user->ownedTeam->name }}
                                            </span>
                                        </td>
                                        <td class="action-icon">
                                            <a href="{{ route('users.show', $user) }}"
                                               class="m-r-15 text-muted f-18"><i
                                                    class="icofont icofont-eye-alt"></i></a>
                                            <a href="{{ route('users.edit', $user) }}"
                                               class="m-r-15 text-muted f-18"><i
                                                    class="icofont icofont-ui-edit"></i></a>
                                            <a href="#!"
                                               class="m-r-15 text-muted f-18 delete"><i
                                                    class="icofont icofont-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Zero config.table end -->
    </div>
    <!-- Delete modal start -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/users" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-b-0">
                        <p>{{ __('Are sur you want to delete this user?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Delete')}} <i class="ti-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete modal end -->

@endsection
