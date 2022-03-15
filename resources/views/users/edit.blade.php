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
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('users.update', $user) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control" type="text" name="name" id="name"
                                       value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{__('Email')}}</label>
                                <input class="form-control" type="email" name="email" id="email"
                                       value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="password">{{ __('Phone') }}</label>
                                <input class="form-control" type="text" name="phone_1" id="phone_1"
                                       value="{{ $user->phone_1 ?? '' }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="password">{{ __('Phone 2') }}</label>
                                <input class="form-control" type="text" name="phone_2" id="phone_2"
                                       value="{{ $user->phone_2 ?? '' }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="commission_rate">{{ __('Commission rate') }}</label>
                                <input class="form-control" type="text" name="commission_rate" id="commission_rate"
                                       value="{{ $user->commission_rate }}">
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
                    </form>

                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>

@endsection
