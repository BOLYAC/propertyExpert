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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script>
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

        $('#tran-btn').on('click', function (e) {
            e.preventDefault()
            $.confirm({
                title: 'Confirm!',
                content: 'Simple confirm!',
                buttons: {
                    confirm: function () {
                        $("#tran-to-agency").submit();
                    },
                    cancel: function () {
                        $.alert('Canceled!');
                    },
                }
            });
        });

        $('.js-select-share').select2();
        window.livewire.on('alert', param => {
            notify(param['message'], param['type'])
        })

        $('#trans-to-sales').on('submit', function (e) {
            e.preventDefault();
            user_id = $('#inCharge').val();
            client_id = '{{ $client->id }}';

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
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Leads') }}</a></li>
    <li class="breadcrumb-item">{{ __('Show:') }} {{ $client->complete_name ?? $client->full_name ?? '' }}</li>
@endsection

@section('content')
    @php
        $requirements_request = [
                        ['id' => 1,'text' => 'Investments'],
                        ['id' => 2,'text' => 'Life style'],
                        ['id' => 3,'text' => 'Investments + Life style'],
                        ['id' => 4,'text' => 'Citizenship'],
                    ];
        $budget_request = [
                        ['id' => 1,'text' => 'Less then 50K'],
                        ['id' => 2,'text' => '50K-100K'],
                        ['id' => 3,'text' => '100K-150K'],
                        ['id' => 4,'text' => '150K200K'],
                        ['id' => 5,'text' => '200K-300K'],
                        ['id' => 6,'text' => '300K-400k'],
                        ['id' => 7,'text' => '400k-500K'],
                        ['id' => 8,'text' => '500K-600k'],
                        ['id' => 9,'text' => '600K-1M'],
                        ['id' => 10,'text' => '1M-2M'],
                        ['id' => 11,'text' => 'More then 2M'],
                    ];
        $rooms_request = [
                        ['id' => 1,'text' => '0 + 1'],
                        ['id' => 2,'text' => '1 + 1'],
                        ['id' => 3,'text' => '2 + 1'],
                        ['id' => 4,'text' => '3 + 1'],
                        ['id' => 5,'text' => '4 + 1'],
                        ['id' => 6,'text' => '5 + 1'],
                        ['id' => 7,'text' => '6 + 1'],
                    ];
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 col-lg-10">
                <!-- Zero config.table start -->
                <div class="card card-with-border">
                    @livewire('client', ['client' => $client])
                </div>
                @include('clients.task-note')
                <div class="col-xl-4 xl-100 box-col-12">
                    <div class="card card-with-border overall-rating">
                        <div class="card-header resolve-complain card-no-border">
                            <h5 class="d-inline-block">Recent Activities</h5><span
                                class="setting-round pull-right d-inline-block mt-0"><i
                                    class="fa fa-spin fa-cog"></i></span>
                        </div>
                        @if($all)
                            @foreach($all as $audit)
                                <div class="card-body pt-0">
                                    <div class="timeline-recent">
                                        <div class="media">
                                            <div class="timeline-line"></div>
                                            <div class="timeline-dot-danger"></div>
                                            <div class="media-body"><span
                                                    class="d-block f-w-600">{{ $audit->user->name ?? '' }} {{ $audit->event }}<span
                                                        class="pull-right light-font f-w-400">{{ optional(\Carbon\Carbon::parse($audit->created_at))->diffForHumans() }}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                <div class="card card-with-border p-2">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('Owned by') }}</h5>
                    </div>
                    <div class="card-body p-2">
                        <div class="inbox">
                            <div class="media active">
                                <div class="media-size-email">
                                    <img class="mr-3 rounded-circle img-50"
                                         style="width: 50px;height:50px;"
                                         src="{{ asset('storage/' . $client->user->image_path) }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $client->user->name }}</h6>
                                    <p>{{ $client->user->roles->first()->name }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @can('share-client')
                            <form id="trans-to-sales">
                                @csrf
                                <div class="form-group form-group-sm">
                                    <select class="form-control form-control-sm" name="inCharge" id="inCharge">
                                        @foreach($users as $user)
                                            <option
                                                value="{{ $user->id }}" {{ $client->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary form-control form-control-sm">
                                    {{ __('Change') }} <i
                                        class="icon-share-alt"></i></button>
                            </form>
                        @endcan
                    </div>
                </div>
            @can('share-client-with')
                <!-- Start Share lead with card -->
                    <div class="card card-with-border">
                        <div class="card-header bg-primary p-4">
                            <h5 class="text-white">{{ __('Share with') }}</h5>
                        </div>
                        <div class="card-body p-2">
                            <form action="{{route('client.shareClient')}}" method="POST" id="share_lead_with">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="lead_id" value="{{ $client->id }}">
                                    <div class="form-group">
                                        <select class="js-select-share form-control form-control-sm"
                                                name="share_with[]" id="share_with"
                                                multiple>
                                            @foreach($users as $user)
                                                @if($client->shareClientWith->contains($user))
                                                    <option value="{{ $user->id }}"
                                                            selected>{{ $user->name ?? '' }}</option>
                                                @else
                                                    <option value="{{ $user->id }}">{{ $user->name ?? ''}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary form-control form-control-sm">{{ __('Share') }}
                                    <i
                                        class="icon-share"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- End share with card -->
            @endcan
            <!-- Transfer to Deal -->
                @can('transfer-lead-to-deal')
                    <div class="card card-with-border">
                        <div class="card-header b-b-info p-4">
                            <h5 class="text-muted">{{ __('Transfer to deal') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.transfer') }}" method="POST">
                                @csrf
                                <input type="hidden" name="clientId" value="{{ $client->id }}">
                                <button class="btn btn-outline-success btn-sm form-control"
                                        id="tran-to">{{ __('Done') }} <i
                                        class="icon-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                @endcan
                @include('clients.documents.index')
                @if($client->leads()->exists())
                    <div class="card card-with-border">
                        <div class="card-header p-4">
                            <h5 class="d-inline-block">{{ __('Deals history') }}</h5>
                        </div>
                        <div class="card-body activity-social">
                            <ul>
                                @foreach($client->leads as $lead)
                                    <li class="border-recent-success">
                                        <small>{{ $lead->created_at->format('Y-m-d') }}</small>
                                        <p class="mb-0">{{ __('Stage') }}: <span
                                                class="f-w-800 text-primary">
                                                @php
                                                    $i = $lead->stage_id;
                                                switch ($i) {
                                                    case 1:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('In contact') . '</span>';
                                                        break;
                                                    case 2:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Appointment Set') . '</span>';
                                                        break;
                                                    case 3:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Follow up') . '</span>';
                                                        break;
                                                    case 4:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Reservation') . '</span>';
                                                        break;
                                                    case 5:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Contract signed') . '</span>';
                                                        break;
                                                    case 6:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Down payment') . '</span>';
                                                        break;
                                                    case 7:
                                                        echo '<span class="badge badge-light-primary f-w-600">' . __('Developer invoice') . '</span>';
                                                        break;
                                                    case 8:
                                                        echo '<span class="badge badge-light-success f-w-600">' . __('Won Deal') . '</span>';
                                                        break;
                                                    case 9:
                                                        echo '<span class="badge badge-light-danger f-w-600">' . __('Lost') . '</span>';
                                                        break;
                                                }
                                                @endphp
                                        </span></p>
                                        <p>{{ __('Name') }} <a
                                                href="{{ route('leads.show', $lead) }}">{{ $lead->lead_name }}</a></p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if($client->StatusLog()->exists())
                    <div class="card card-with-border">
                        <div class="card-header">
                            <h5 class="d-inline-block">{{ __('Status activity') }}</h5>
                        </div>
                        <div class="card-body activity-social">
                            <ul>
                                @foreach($client->StatusLog as $log)
                                    <li class="border-recent-warning">
                                        <small>{{ $log->created_at->format('Y-m-d H:i') }}</small>
                                        <p class="mb-0">{{ __('Status change to') }}: <span
                                                class="f-w-800 text-primary">{{ $log->status_name }}</span></p>
                                        <P>by <a href="#">{{ $log->user_name }}</a></P>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="card card-with-border">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('History') }}</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ __('Created By:') }} </h6>
                        <p>{{ $client->createBy->name }}</p>
                        <h6>{{ __('Created time:') }} </h6>
                        <p>{{ Carbon\Carbon::parse($client->created_at)->format('Y-m-d H:m') }}</p>
                        <h6>{{ __('Modified By:') }} </h6>
                        <p>{{ $client->updateBy->name }}</p>
                        <h6>{{ __('Modified time:') }} </h6>
                        <p>{{ Carbon\Carbon::parse($client->updated_at)->format('Y-m-d H:m') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
