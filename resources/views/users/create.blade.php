@extends('layouts.vertical.master')
@section('title', '| New user')

@section('style_before')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('User lists') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create user') }}</li>
@endsection

@section('content')

    <div class="container-fluid">
        @include('partials.flash-message')
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-8">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col-6">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input class="form-control sm" type="text" name="name" id="name"
                                           value="{{ old('name') }}">
                                </div>
                                <div class=" form-group input-group-sm col-6">
                                    <label for="email input-group-sm">{{ __('Email') }}</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                           value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col-6">
                                    <label for="password">{{ __('Phone') }}</label>
                                    <input class="form-control" type="text" name="phone_1" id="phone_1">
                                </div>
                                <div class="form-group input-group-sm col-6">
                                    <label for="password">{{ __('Phone 2') }}</label>
                                    <input class="form-control" type="text" name="phone_2" id="phone_2">
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="commission_rate">{{ __('Mac address') }}</label>
                                <input class="form-control" type="text" name="mac_address" id="mac_address"
                                       value="{{ $user->mac_address }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="roles">{{__('Role')}}</label>
                                <select class="custom-select custom-select-sm js-example-basic-single" type="roles"
                                        name="roles[]"
                                        id="roles" multiple>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="department">{{__('Department')}}</label>
                                <select class="custom-select custom-select-sm" name="department_id" id="department">
                                    <option value=""> -- {{ __('Select department') }} --</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-warning">{{__('Cancel')}}</a>
                        </div>
                        <
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h5>Simple permission</h5>
                            </div>
                            <div class="col">
                                <div class="form-group m-t-15">
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_country" type="checkbox" name="can_sse_country">
                                        <label for="can_sse_country">{{ __('Can see country') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_language" type="checkbox" name="can_sse_language">
                                        <label for="can_sse_language">{{ __('Can see language') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_source" type="checkbox" name="can_sse_source">
                                        <label for="can_sse_source">{{ __('Can see source') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_phone" type="checkbox" name="can_sse_phone">
                                        <label for="can_sse_phone">{{ __('Can see phone') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_email" type="checkbox" name="can_sse_email">
                                        <label for="can_sse_email">{{ __('Can see email') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero config.table end -->
            </div>
            /form>
    </div>
@endsection
