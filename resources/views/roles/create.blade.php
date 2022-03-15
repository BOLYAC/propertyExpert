@extends('layouts.vertical.master')
@section('title', 'New role')
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Role lists') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create roles') }}</li>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 mx-auto">
            @include('partials.flash-message')
            <!-- Zero config.table start -->
                <div class="card">
                    <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body b-t-primary">
                            <div class="form-group input-group-sm">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control sm" type="text" name="name" id="name"
                                       value="{{ old('name') }}">
                            </div>
                            @foreach($permission as $value)
                                <label>
                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}">
                                    {{ $value->name }}
                                </label>
                                <br/>
                            @endforeach

                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection
