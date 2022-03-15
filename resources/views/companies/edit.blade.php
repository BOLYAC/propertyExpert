@extends('layouts.vertical.master')
@section('title', '| New agency')

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

        $('.js-country-all').select2({
            placeholder: "Search a source",
            ajax: {
                url: "{{ route('source.name') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        window.livewire.on('alert', param => {
            notify(param['message'], param['type'])
        })
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">{{ __('Companies list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Company agency') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <form action="{{ route('companies.update', $company) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="form-group input-group-sm">
                                <label for="title">{{ __('Company name') }}</label>
                                <input class="form-control form-control-sm" type="text" name="name" id="name"
                                       value="{{ old('name', $company->name) }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="source_id">{{ __('Company Type') }}</label>
                                <select class="form-control js-country-all" name="source_id" id="source_id">
                                    <option value="{{ $company->source_id }}"
                                            selected>{{ $company->source->name }}</option>
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input class="form-control form-control-sm" type="text" name="phone"
                                       id="phone"
                                       value="{{ old('phone', $company->phone) }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea class="summernote" type="text" name="address"
                                          id="address">{!! old('address', $company->address) !!}</textarea>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="person_name">{{ __('Person Name') }}</label>
                                <input class="form-control form-control-sm" type="text" name="person_name"
                                       id="person_name"
                                       value="{{ old('person_name', $company->person_name) }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="person_phone">{{ __('Person phone') }}</label>
                                <input type="text" class="form-control form-control-sm" name="person_phone"
                                       value="{{ old('person_name', $company->person_phone) }}"
                                       id="person_phone">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="person_email">{{ __('Person e-mail') }}</label>
                                <input class="form-control form-control-sm" type="text" name="person_email"
                                       id="person_email" value="{{ old('person_email', $company->person_email) }}">
                            </div>
                        </div>
                        <div class="card-footer b-t-primary">
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ route('companies.index') }}"
                               class="btn btn-sm btn-warning">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
                @include('companies.partials.task-note')
            </div>
            <div class="col-4">
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
                                         src="{{ asset('storage/' . optional($company->user)->image_path) }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $company->user->name ?? '' }}</h6>
                                    {{--                                    <p>{{ $agency->user->roles->first()->name }}</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @can('company-to-deal')
                    <div class="card card-with-border">
                        <div class="card-header b-b-info p-4">
                            <h5 class="text-muted">{{ __('Transfer to deal') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('companyToDealStep.transfer') }}" method="POST">
                                @csrf
                                <input type="hidden" name="companyId" value="{{ $company->id }}">
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
                        <p>{{ $company->updateBy->name }}</p>
                        <h6>{{ __('Created time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($company->created_at)->format('Y-m-d H:m') }}
                        </p>
                        <h6>{{ __('Modified time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($company->updated_at)->format('Y-m-d H:m') }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection

