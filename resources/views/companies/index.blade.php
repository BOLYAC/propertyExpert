@extends('layouts.vertical.master')
@section('title', '| Companies')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .select2-search input {
            font-size: 12px;
        }

        .select2-results {
            font-size: 12px;
        }

        .select2-results__option--highlighted {
            font-size: 12px;
        }

        .select2-results__option[aria-selected=true] {
            font-size: 12px;
        }

        .select2-results__options {
            font-size: 12px !important;
        }

        .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-selection__rendered {
            line-height: 16px !important;
        }

        .select2-container .select2-selection--single {
            height: 16px !important;
        }

        .select2-selection__arrow {
            height: 16px !important;
        }
    </style>
@endsection

@section('script')

    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script>
        let table = $('#res-config').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('companies.index') }}',
                data: function (d) {
                    d.type = $('select[name=type_filter]').val();
                    d.user = $('select[name=user_filter]').val();
                }
            },
            "drawCallback": function (settings) {
                let api = this.api();
                // Output the data for the visible rows to the browser's console
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'name', name: 'name'},
                {data: 'company_type', name: 'company_type'},
                {data: 'phone', name: 'phone'},
                {data: 'person_name', name: 'person_name'},
                {data: 'person_phone', name: 'person_phone'},
                {data: 'person_email', name: 'person_email'},
                {data: 'action', name: 'action'},
            ],
            order: [[1, 'asc']]
        });

        // Clear form
        $('#refresh').click(function () {
            $('select[name=type_filter]').val('');
            $('select[name=user_filter]').val('');
            table.DataTable().destroy();
        });
        // Search form
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            table.draw();
        });

        table.on('click', '.delete', function () {
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }
            let data = table.row($tr).data();
            $('#deleteForm').attr('action', 'companies/' + data[0]);
            $('#deleteModal').modal('show');
        })
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Companies') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        @include('partials.flash-message')
        <div class="row">
            <div class="col-sm-2">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">{{ __('Filter companies by:') }}</h6>
                    </div>
                    <form id="search-form">
                        <div class="card-body p-2">
                            <div class="form-group mb-2">
                                <select class="custom-select custom-select-sm" id="type_filter"
                                        name="type_filter">
                                    <option value="">{{ __('Select Type') }}</option>
                                </select>
                            </div>
                            @if(auth()->user()->hasRole('Admin'))
                                <div class="form-group mb-2">
                                    <select name="user_filter" id="user_filter"
                                            class="custom-select custom-select-sm">
                                        <option value="">{{ __('Assigned') }}</option>
                                        @foreach($users as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif(auth()->user()->hasRole('Manager'))
                                @if(auth()->user()->ownedTeams()->count() > 0)
                                    <div class="form-group mb-2">
                                        <select name="user_filter" id="user_filter"
                                                class="custom-select custom-select-sm">
                                            <option value="">{{ __('Select Assigned') }}</option>
                                            @foreach(auth()->user()->currentTeam->allUsers() as $user)
                                                <option
                                                    value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="card-footer p-2">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary" type="submit">{{ __('Filter') }}</button>
                                <button class="btn btn-light" type="button" id="refresh">{{ __('Clear') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header b-b-primary b-t-primary p-2">
                        <a href="{{ route('companies.create') }}"
                           class="btn btn-sm btn-outline-primary">{{ __('New Company') }} <i class="icon-plus"></i></a>
                        <a href="{{ route('companies.field.report') }}" class="btn btn-sm btn-outline-primary">{{ __('Generate report') }} <i class="icon-archive"></i></a>
                    </div>
                    <div class="card-body px-2">
                        <div class="table-responsive">
                            <table id="res-config"
                                   class="display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>{{ __('Assigned') }}</th>
                                    <th>{{ __('Company name') }}</th>
                                    <th>{{ __('Company Type') }}</th>
                                    <th>{{ __('Company Phone') }}</th>
                                    <th>{{ __('Contact Person Name') }}</th>
                                    <th>{{ __('Contact Person Phone') }}</th>
                                    <th>{{ __('Contact Person E-mail') }}</th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                                </thead>
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
                    <h5 class="modal-title">{{__('Delete agency')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/companies" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-b-0">
                        <p>{{ __('Are sur you want to delete this agency?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Delete') }} <i class="icon-trash"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete modal end -->

@endsection
