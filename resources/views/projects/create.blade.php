@extends('layouts.vertical.master')
@section('title', '| Project create')
@section('style_before')
    <!-- Summernote.css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>

@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('Project list') }} </a></li>
    <li class="breadcrumb-item">{{ __('New project') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col-12">
                                    <label for="title">{{ __('Company name') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="company_name"
                                           id="company_name "
                                           value="{{ old('company_name') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="name">{{ __('Phone') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="phone_1" id="phone_1"
                                           value="{{ old('phone_1') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="in_charge">{{ __('Phone 2') }}</label>
                                    <input class="form-control sm" type="text" name="phone_2" id="phone_2"
                                           value="{{ old('phone_2') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="address">{{ __('Text address') }}</label>
                                    <textarea class="summernote" type="text" name="text_address"
                                              id="address">{{ old('text_address') }}</textarea>
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="note">{{ __('Text office') }}</label>
                                    <textarea class="summernote" type="text" name="text_office"
                                              id="note"> {{ old('text_office') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col-sm">
                                    <label for="commission_rate">{{ __('Commission rate') }}</label>
                                    <input class="form-control sm" type="text" name="commission_rate"
                                           id="commission_rate"
                                           value="{{ old('commission_rate') }}">
                                </div>
                                <div class="form-group input-group-sm col-sm">
                                    <label for="tax_number">{{ __('Tax ID') }}</label>
                                    <input class="form-control sm" type="text" name="tax_number"
                                           id="tax_number"
                                           value="{{ old('tax_number') }}">
                                </div>
                                <div class="form-group input-group-sm col-sm">
                                    <label for="tax_branch">{{ __('Tax branch') }}</label>
                                    <input class="form-control sm" type="text" name="tax_branch"
                                           id="tax_branch"
                                           value="{{ old('tax_branch') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="phone">{{ __('Project name') }}</label>
                                    <input class="form-control sm" type="text" name="project_name" id="project_name"
                                           value="{{ old('project_name') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="type">{{ __('Type') }}</label>
                                    <select name="type" id="type" class="form-control form-control-sm">
                                        <option value="1">{{ __('Apartment') }}</option>
                                        <option value="2">{{ __('Home Office') }}</option>
                                        <option value="3">{{ __('Office') }}</option>
                                        <option value="4">{{ __('Residential') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="note">{{ __('Address') }}</label>
                                    <textarea class="summernote" type="text" name="address"
                                              id="note"> {{ old('address') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="phone">{{ __('Website') }}</label>
                                    <input class="form-control sm" type="text" name="link" id="link"
                                           value="{{ old('link') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="phone">{{ __('Min Price') }}</label>
                                    <input class="form-control sm" type="text" name="min_price" id="min_price"
                                           value="{{ old('min_price') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Max price') }}</label>
                                    <input class="form-control sm" type="text" name="max_price" id="max_price"
                                           value="{{ old('max_price') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="min_size">{{ __('Min Size') }}</label>
                                    <input class="form-control sm" type="text" name="min_size" id="min_size"
                                           value="{{ old('min_size') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="max_size">{{ __('Max Size') }}</label>
                                    <input class="form-control sm" type="text" name="max_size" id="max_size"
                                           value="{{ old('max_size') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Map') }}</label>
                                    <input class="form-control sm" type="text" name="map" id="map"
                                           value="{{ old('map') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Drive Link') }}</label>
                                    <input class="form-control sm" type="text" name="drive" id="drive"
                                           value="{{ old('drive') }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ route('projects.index') }}"
                               class="btn btn-sm btn-warning">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
