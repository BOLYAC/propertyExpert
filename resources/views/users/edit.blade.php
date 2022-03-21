@extends('layouts.vertical.master')
@section('title', '| Edit user')

@section('style_before')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endsection

@section('style')

@endsection

@section('script')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('User lists') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit user') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        @include('partials.flash-message')
        <form action="{{ route('users.update', $user) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-8">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input class="form-control" type="text" name="name" id="name"
                                           value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="form-group col">
                                    <label for="email">{{__('Email')}}</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                           value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="password">{{ __('Phone') }}</label>
                                    <input class="form-control" type="text" name="phone_1" id="phone_1"
                                           value="{{ $user->phone_1 ?? '' }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="password">{{ __('Phone 2') }}</label>
                                    <input class="form-control" type="text" name="phone_2" id="phone_2"
                                           value="{{ $user->phone_2 ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="commission_rate">{{ __('Mac address') }}</label>
                                <input class="form-control" type="text" name="mac_address" id="mac_address"
                                       value="{{ $user->mac_address }}">
                            </div>
                            <div class="form-group">
                                <label for="roles">{{ __('Role') }}</label>
                                <select class="js-example-basic-multiple col-sm-12" name="roles[]" id="roles"
                                        multiple>
                                    @foreach($roles as $role)
                                        @if(in_array($role, $userRole))
                                            <option value="{{ $role }}" selected="true">{{ $role}}</option>
                                        @else
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="manager">{{ __('Manager') }}</label>
                                <select class="col-sm-12 form-control" name="user_id" id="manager">
                                    <option value=""> -- {{ __('Select the manager') }} --</option>
                                    @foreach($managers as $manager)
                                        @if($manager->id == $user->user_id )
                                            <option value="{{ $manager->id }}"
                                                    selected>{{ $manager->name }}</option>
                                        @else
                                            <option
                                                value="{{ $manager->id }}">{{ $manager->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="department">{{__('Department')}}</label>
                                <select class="form-control" name="department_id" id="department">
                                    <option value="0"> -- {{ __('Select department') }} --</option>
                                    @foreach($departments as $department)
                                        <option
                                            value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Photo profile') }}</label>
                                <input type="file" name="full" class="form-control">
                            </div>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->image_path) }}" alt="" class="img-fluid img-">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('Save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ url()->route('users.index') }}" class="btn btn-sm btn-warning">
                                {{__('Cancel')}}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Zero config.table end -->
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h5>Simple permission</h5>
                            </div>
                            <div class="col">
                                <div class="form-group m-t-15">
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_country" type="checkbox"
                                               name="can_sse_country" {{ $user->can_sse_country == 1 ? 'checked' : '' }}>
                                        <label for="can_sse_country">{{ __('Can see country') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_language" type="checkbox"
                                               name="can_sse_language" {{ $user->can_sse_language == 1 ? 'checked' : '' }}>
                                        <label for="can_sse_language">{{ __('Can see language') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_source" type="checkbox"
                                               name="can_sse_source" {{ $user->can_sse_source == 1 ? 'checked' : '' }}>
                                        <label for="can_sse_source">{{ __('Can see source') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_phone" type="checkbox"
                                               name="can_sse_phone" {{ $user->can_sse_phone == 1 ? 'checked' : '' }}>
                                        <label for="can_sse_phone">{{ __('Can see phone') }}</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="can_sse_email" type="checkbox"
                                               name="can_sse_email" {{ $user->can_sse_email == 1 ? 'checked' : '' }}>
                                        <label for="can_sse_email">{{ __('Can see email') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
