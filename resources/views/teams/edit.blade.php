@extends('layouts.vertical.master')
@section('title', 'Edit user')

@section('style_before')
    <!-- Notification.css -->
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endsection

@section('style')

@endsection

@section('script')

    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>


@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">{{ __('Team lists') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit team') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('teams.update', $team) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="form-group">
                                <label class="form-control-label" for="owner">{{ __('Team owner') }}</label>
                                <select name="user_id" id="owner" class="form-control">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $team->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control sm" type="text" name="name" id="name"
                                       value="{{ old('name', $team->name) }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="users">{{ __('Users') }}</label>
                                <select class="form-control js-example-basic-single" name="users[]" id="users"
                                        multiple>
                                    @foreach($users as $user)
                                        @if($team->users->contains($user))
                                            <option value="{{ $user->id }}"
                                                    selected="true">{{ $user->name }}</option>
                                        @else
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ route('teams.index') }}"
                               class="btn btn-sm btn-danger">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>

@endsection
