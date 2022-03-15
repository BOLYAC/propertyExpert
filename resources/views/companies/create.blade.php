@extends('layouts.vertical.master')
@section('title', '| New agency')

@section('style_before')
    <!-- Summernote.css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <script>
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
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">{{ __('agency list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create agency') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="card">
                    <form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body b-t-primary">
                            <div class="form-group input-group-sm">
                                <label for="title">{{ __('Company name') }}</label>
                                <input class="form-control form-control-sm" type="text" name="name" id="name"
                                       value="{{ old('name') }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="source_id">{{ __('Company Type') }}</label>
                                <select class="form-control js-country-all" name="source_id" id="source_id">
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input class="form-control form-control-sm" type="text" name="phone"
                                       id="phone"
                                       value="{{ old('phone') }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea class="summernote" type="text" name="address"
                                          id="address">{{ old('address') }}</textarea>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="person_name">{{ __('Person Name') }}</label>
                                <input class="form-control form-control-sm" type="text" name="person_name"
                                       id="person_name"
                                       value="{{ old('person_name') }}">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="person_phone">{{ __('Person phone') }}</label>
                                <input type="text" class="form-control form-control-sm" name="person_phone"
                                       id="person_phone">
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="person_email">{{ __('Person e-mail') }}</label>
                                <input class="form-control form-control-sm" type="text" name="person_email"
                                       id="person_email" value="{{ old('person_email') }}">
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
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection

