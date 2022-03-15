@extends('layouts.vertical.master')
@section('title', 'New deal')

@section('style_before')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">{{ __('Deal lists') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create deal') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        @include('partials.flash-message')
        <form action="{{ route('leads.store') }}" method="post" role="form">
            <div class="row">
                @csrf
                <div class="col-sm-8">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-body b-t-primary">
                            <div class="form-group input-group-sm">
                                <label for="title">{{ __('Title') }}</label>
                                <input class="form-control sm" type="text" name="title" id="title"
                                       value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="description"></label>
                                <textarea class="summernote" name="description" id="description"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Zero config.table end -->
                <div class="col-4">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <div class="form-group input-group-sm">
                                <label for="user_assigned_id">{{ __('Assign user') }}</label>
                                <select class="form-control" name="user_assigned_id" id="user_assigned_id">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group input-group-sm">
                                <label for="client_id">{{ __('Assign lead') }}</label>
                                <select class="form-control" name="client_id" id="client_id">
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="status">{{ __('Stage') }}</label>
                                <select name="stage_id" id="stage_id"
                                        class="form-control form-control-sm">
                                    <option value="1">{{ __('In contact') }}</option>
                                    <option value="2">{{ __('Appointment Set') }}</option>
                                    <option value="3">{{ __('Follow up') }}</option>
                                    <option value="4">{{ __('Reservation') }}</option>
                                    <option value="5">{{ __('contract signed') }}</option>
                                    <option value="6">{{ __('Down payment') }}</option>
                                    <option value="7">{{ __('Developer invoice') }}</option>
                                    <option value="8">{{ __('Won Deal') }}</option>
                                    <option value="9">{{ __('Lost') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('save') }}
                        <i class="icon-save"></i></button>
                    <a href="{{ url()->route('leads.index') }}"
                       class="btn btn-warning">
                        {{ __('Cancel') }}
                    </a>
                </div>

            </div>
        </form>
    </div>

@endsection
