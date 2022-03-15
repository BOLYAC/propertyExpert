@extends('layouts.vertical.master')
@section('title', '| New user')

@section('style_before')
    <!-- Notification.css -->
    <!-- Plugins css start-->
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
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body  b-t-primary">
                            <div class="form-group input-group-sm">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control sm" type="text" name="name" id="name"
                                       value="{{ old('name') }}">
                            </div>
                            <div class=" form-group input-group-sm">
                                <label for="email input-group-sm">{{ __('Email') }}</label>
                                <input class="form-control" type="email" name="email" id="email"
                                       value="{{ old('email') }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="password">{{ __('Phone') }}</label>
                                <input class="form-control" type="text" name="phone_1" id="phone_1">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="password">{{ __('Phone 2') }}</label>
                                <input class="form-control" type="text" name="phone_2" id="phone_2">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="commission_rate">{{ __('Commission rate') }}</label>
                                <input class="form-control" type="text" name="commission_rate" id="commission_rate">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="roles">{{__('Role')}}</label>
                                <select class="custom-select custom-select-sm js-example-basic-single" type="roles" name="roles[]"
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
                            <div class="form-group input-group-sm">
                                <label for="department_ids">{{__('Other Department')}}</label>
                                <select class="custom-select custom-select-sm js-example-basic-single" name="departments_ids[]" id="department_ids" multiple>
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
                    </form>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection
