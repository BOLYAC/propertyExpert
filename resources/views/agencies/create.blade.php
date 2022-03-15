@extends('layouts.vertical.master')
@section('title', '| New agency')

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
    <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">{{ __('agency list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create agency') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="card">
                    <form action="{{ route('agencies.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="title" id="title"
                                           value="{{ old('title') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="name" id="name"
                                           value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="in_charge">{{ __('Owner') }}</label>
                                    <input class="form-control sm" type="text" name="in_charge" id="in_charge"
                                           value="{{ old('in_charge') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="tax_number">{{ __('Tax number') }}</label>
                                    <input class="form-control sm" type="text" name="tax_number" id="tax_number"
                                           value="{{ old('tax_number') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="phone">{{ __('Agency phone') }}</label>
                                    <input class="form-control sm" type="text" name="phone" id="phone"
                                           value="{{ old('phone') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Agency email') }}</label>
                                    <input class="form-control sm" type="text" name="email" id="email"
                                           value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="commission_rate">{{ __('Commission rate') }}</label>
                                    <input class="form-control sm" type="text" name="commission_rate"
                                           id="commission_rate"
                                           value="{{ old('commission_rate') }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="contract_status">{{ __('Contract status') }}</label>
                                    <input class="form-control sm" type="text" name="contract_status"
                                           id="contract_status"
                                           value="{{ old('contract_status') }}">
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea class="summernote" type="text" name="address"
                                          id="address">{{ old('address') }}</textarea>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea class="summernote" type="text" name="note"
                                          id="note"> {{ old('note') }}</textarea>
                            </div>
                            {{--<div class="form-group">
                                <div class="border-checkbox-section pl-4">
                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                        <input class="border-checkbox" type="checkbox" id="status" name="status">
                                        <label class="border-checkbox-label" for="status">{{__('Status')}}</label>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <div class="card-footer b-t-primary">
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ route('agencies.index') }}"
                               class="btn btn-sm btn-warning">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection

