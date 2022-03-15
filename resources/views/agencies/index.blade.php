@extends('layouts.vertical.master')
@section('title', '| Agencies')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')

    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>

    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="badge badge-light-primary">Leads list</div>
        <div class="table-responsive">
            <table class="display" id="client-{{id}}"
                   style="width: 100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>New</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Assigned</th>
                    <th>Source</th>
                </tr>
                </thead>
            </table>
        </div>
        @endverbatim
    </script>
    <script>
        let template = Handlebars.compile($("#details-template").html());
        let table = $('#res-config').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('agencies.index') }}',
                data: function (d) {
                    d.type = $('select[name=type_filter]').val();
                    d.user = $('select[name=user_filter]').val();
                    d.department = $('select[name=department_filter]').val();
                    d.country = $('select[name=country_filter]').val();
                    d.city = $('input[name=city_filter]').val();
                }
            },
            "drawCallback": function (settings) {
                let api = this.api();
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
                {data: 'id', name: 'id'},
                {data: 'company_type', name: 'company_type'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action'},
            ],
            order: [[1, 'asc']]
        });
        // Add event listener for opening and closing details
        $('#res-config tbody').on('click', 'td.details-control', function () {
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
                responsive: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                ajax:
                    {
                        url: data.details_url,
                    },
                columns: [
                    {data: 'public_id', name: 'public_id'},
                    {data: 'type', name: 'type'},
                    {data: 'full_name', name: 'full_name'},
                    {data: 'status', name: 'status'},
                    {data: 'assigned', name: 'assigned'},
                    {data: 'source_id', name: 'source_id'},
                ]
            })
        }

        // Clear form
        $('#refresh').click(function () {
            $('select[name=type_filter]').val('');
            $('select[name=user_filter]').val('');
            $('select[name=department_filter]').val('');
            $('select[name=country_filter]').val('');
            $('input[name=city_filter]').val('');
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
            $('#deleteForm').attr('action', 'agencies/' + data[0]);
            $('#deleteModal').modal('show');
        })
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Agencies') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        @include('partials.flash-message')
        <div class="row">
            <div class="col-sm-2">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">{{ __('Filter agency by:') }}</h6>
                    </div>
                    <form id="search-form">
                        <div class="card-body p-2">
                            <div class="form-group mb-2">
                                <select class="custom-select custom-select-sm" id="type_filter"
                                        name="type_filter">
                                    <option value="">{{ __('Select Type') }}</option>
                                    <option value="1">{{ __('Company') }}</option>
                                    <option value="2">{{ __('Freelance') }}</option>
                                </select>
                            </div>
                            @if(auth()->user()->hasRole('Admin'))
                                <div class="form-group mb-2">
                                    <select name="department_filter" id="department_filter"
                                            class="custom-select custom-select-sm">
                                        <option value="">{{ __('Department') }}</option>
                                        @foreach($departments as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                            <div class="form-group mb-2">
                                <select name="country_filter" id="country_filter"
                                        class="custom-select custom-select-sm">
                                    <option value="">{{ __('Country') }}</option>
                                    @foreach($countries as $country)
                                        <option
                                            value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <input name="city_filter" id="city_filter"
                                       class="form-control form-control-sm" placeholder="City">
                            </div>
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
                        <a href="{{ route('agencies.create') }}"
                           class="btn btn-sm btn-outline-primary">{{ __('New Agency') }} <i class="icon-plus"></i></a>
                    </div>
                    <div class="card-body px-2">
                        <div class="table-responsive">
                            <table id="res-config"
                                   class="display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th width="5%">ID</th>
                                    <th>{{ __('Agency type') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th width="10%"></th>
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
                <form action="/agencies" method="POST" id="deleteForm">
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
