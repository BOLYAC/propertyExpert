@extends('layouts.vertical.master')
@section('title', '| Show client')
@section('style_before')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- ToDo css -->
    <link rel="stylesheet" href="{{ asset('assets/css/todo.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection
@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/notify/notify-script.js') }}"></script>
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/buttons.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.colReorder.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.rowReorder.min.js')}}"></script>

    <script>
        let table = $('#res-config').DataTable();

        function notify(title, message, type, icon) {
            $.notify({
                    icon: icon,
                    message: message
                },
                {
                    type: type,
                    allow_dismiss: false,
                    newest_on_top: false,
                    mouse_over: false,
                    showProgressbar: false,
                    spacing: 10,
                    timer: 2000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 30,
                        y: 30
                    },
                    delay: 1000,
                    z_index: 10000,
                    animate: {
                        enter: 'animated bounce',
                        exit: 'animated bounce'
                    },
                });
        }

        window.livewire.on('alert', param => {
            notify(param['message'], param['type'])
        })

        $('#trans-to-sales').on('submit', function (e) {
            e.preventDefault();
            user_id = $('#inCharge').val();
            client_id = '{{ $agency->id }}';

            $.ajax({
                url: "{{route('sales.share')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    client_id: client_id,
                },
                success: function () {
                    notify('Client transferred successfully', 'success');
                },
                error: function (response) {
                    notify('already have been assigned to this user', 'danger');
                },
            });
        });
    </script>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">{{ __('Leads') }}</a></li>
    <li class="breadcrumb-item">{{ __('Show:') }} {{ $agency->name ?? $agency->title ?? '' }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 col-lg-10">
                <!-- Zero config.table start -->
                <div class="card card-with-border">
                    <div>
                        <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
                            <h5 class="mr-auto mt-2">{{ __('Agency:') }}
                                {{ $agency->name ?? $agency->title ?? '' }}</h5>
                            <a href="{{ route('agencies.index') }}" class="btn btn-sm btn-warning mr-2"><i
                                    class="icon-arrow-left"></i> {{ __('Back') }}</a>
                            @can('agency-edit')
                                <a href="{{ route('agencies.edit', $agency) }}" class="btn btn-sm btn-primary">
                                    {{ __('Edit') }}
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table m-0">
                                        <tbody>
                                        <tr>
                                            <th scope="row">{{ __('Type') }}</th>
                                            <td>{{ $agency->company_type === 1 ? __('Company') : __('Freelance') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Name') }}</th>
                                            <td>{{ $agency->name ?? $agency->title ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Owner') }}</th>
                                            <td>{{ $agency->in_charge ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Tax number') }}</th>
                                            <td>{{ $agency->tax_number ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Tax branch') }}</th>
                                            <td>{{ $agency->tax_branch ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Tax branch') }}</th>
                                            <td>{{ $agency->tax_branch ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Agency phone') }}</th>
                                            <td>
                                                @livewire('agency-calls', ['agency' => $agency])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Agency email') }}</th>
                                            <td>{{ $agency->email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Representatives') }}</th>
                                            <td>
                                                @if(!is_null($agency->representatives))
                                                    @for ($i = 0; $i < count($agency->representatives); $i++)
                                                        <strong>{{ __('Name:') }}</strong>  {{ $agency->representatives[$i]['key'] ?? '' }}
                                                        <stong>{{ __('Rep phone:') }}</stong> {{ $agency->representatives[$i]['value'] ?? '' }}
                                                        <br>
                                                    @endfor
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end of table col-lg-6 -->
                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th scope="row">{{__('Commission rate')}}</th>
                                            <td>
                                                {{ $agency->commission_rate ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Contract status') }}</th>
                                            <td>
                                                {{ $agency->contract_status ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Country') }}</th>
                                            <td>
                                                @foreach($countries as $c)
                                                    {{ $agency->country == $c->id ? $c->name : '' }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('City') }}</th>
                                            <td>
                                                {{ $agency->city ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Address') }}</th>
                                            <td>
                                                {!! $agency->address ?? '' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Note') }}</th>
                                            <td>
                                                {!! $agency->note ?? '' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('Projects') }}</th>
                                            <td>
                                                @if(!is_null($agency->projects))
                                                    @foreach($agency->projects as $project)
                                                        <strong>
                                                            {{ $project }}
                                                        </strong>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('agencies.partials.task-note')
                <div class="card card-with-border">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="res-config"
                                       class="table table-bordered nowrap display compact">
                                    <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Assigned') }}</th>
                                        <th>{{ __('Source') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($agency->clients as $client)
                                        <tr>
                                            <td>{{ $client->public_id }}</td>
                                            <td>
                                                <a href="{{ route('clients.edit', $client) }}">{{ $client->full_name }}</a>
                                            </td>
                                            <td>
                                                @switch($client->status)
                                                    @case(1)
                                                    <span
                                                        class="badge badge-default">{{ __('New Lead') }}</span>
                                                    @break
                                                    @case(8)
                                                    <span
                                                        class="badge badge-default">{{ __('No Answer') }}</span>
                                                    @break
                                                    @case(12)
                                                    <span
                                                        class="badge badge-default">{{ __('In progress') }}</span>
                                                    @break
                                                    @case(3)
                                                    <span class="badge badge-default">{{ __('Potential
                            appointment') }}</span>
                                                    @break
                                                    @case(4)
                                                    <span class="badge badge-default">{{ __('Appointment
                            set') }}</span>
                                                    @break
                                                    @case(10)
                                                    <span class="badge badge-default">{{ __('Appointment
                            follow up') }}</span>
                                                    @break
                                                    @case(5)
                                                    <span
                                                        class="badge badge-default">{{ __('Sold') }}</span>
                                                    @break
                                                    @case(13)
                                                    <span
                                                        class="badge badge-default">{{ __('Unreachable') }}</span>
                                                    @break
                                                    @case(7)
                                                    <span
                                                        class="badge badge-default">{{ __('Not interested') }}</span>
                                                    @break
                                                    @case(11)
                                                    <span
                                                        class="badge badge-default">{{ __('Low budget') }}</span>
                                                    @break
                                                    @case(9)
                                                    <span
                                                        class="badge badge-default">{{ __('Wrong Number') }}</span>
                                                    @break
                                                    @case(14)
                                                    <span
                                                        class="badge badge-danger">{{ __('Unqualified') }}</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td><span
                                                    class="badge badge-success">{{ $client->user->name ?? '' }}</span>
                                            </td>
                                            <td>{{ optional($client->source)->name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                <div class="card card-with-border">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('Owned by') }}</h5>
                    </div>
                    <div class="card-body pl-2 pr-2 pt-4">
                        <div class="inbox">
                            <div class="media active">
                                <div class="media-size-email">
                                    <img class="mr-3 rounded-circle img-50"
                                         style="width: 50px;height:50px;"
                                         src="{{ asset('storage/' . optional($agency->user)->image_path) }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $agency->user->name ?? '' }}</h6>
                                    {{--                                    <p>{{ $agency->user->roles->first()->name }}</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @can('transfer-lead-to-deal')
                    <div class="card card-with-border">
                        <div class="card-header b-b-info p-4">
                            <h5 class="text-muted">{{ __('Transfer to deal') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('agencyToDealStep.transfer') }}" method="POST">
                                @csrf
                                <input type="hidden" name="agencyId" value="{{ $agency->id }}">
                                <button class="btn btn-outline-success btn-sm form-control"
                                        id="tran-to">{{ __('Done') }} <i
                                        class="icon-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                @endcan
                <div class="card card-with-border">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('History') }}</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ __('Modified By:') }} </h6>
                        <p>{{ $agency->updateBy->name }}</p>
                        <h6>{{ __('Created time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($agency->created_at)->format('Y-m-d H:m') }}
                        </p>
                        <h6>{{ __('Modified time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($agency->updated_at)->format('Y-m-d H:m') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
