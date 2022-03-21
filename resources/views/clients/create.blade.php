@extends('layouts.vertical.master')
@section('title', '| Lead Create')
@section('style_before')
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <script>

        $('.js-select2').select2();
        $('.js-country-all').select2({
            placeholder: "Search a country",
            ajax: {
                url: "{{ route('country.name') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.name
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.js-nationality-all').select2({
            placeholder: "Search a nationality",
            ajax: {
                url: "{{ route('nationality.name') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.name
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.js-language-all').select2({
            placeholder: "Select a language",
            ajax: {
                url: "{{ route('language.name') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.name
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
    <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">{{ __('Leads') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create lead') }}</li>
@endsection

@section('content')
    <!-- Main-body start -->
    @include('partials.flash-message')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST"
                      role="form">
                    @csrf
                    <div class="row">
                        <div class="col-md">
                            <div class="row">
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="first_name">First
                                        name</label>
                                    <input type="text" name="first_name" id="first_name"
                                           class="form-control form-control-sm"
                                           value="{{ old('first_name') }}">
                                </div>

                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="last_name">Last
                                        name</label>
                                    <input type="text" name="last_name" id="last_name"
                                           class="form-control form-control-sm"
                                           value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="client_number">Phone
                                        number (+90xxxxxxxxx)</label>
                                    <input type="text" name="client_number"
                                           id="client_number"
                                           class="form-control form-control-sm phone"
                                           value="{{ old('client_number') }}">
                                </div>
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="client_number_2">Phone
                                        number 2 (+90xxxxxxxxx)</label>
                                    <input type="text" name="client_number_2"
                                           id="client_number_2"
                                           class="form-control form-control-sm phone"
                                           value="{{ old('client_number_2') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="client_email">E-mail</label>
                                    <input type="email" name="client_email"
                                           id="client_email"
                                           class="form-control form-control-sm"
                                           value="{{ old('client_email') }}">
                                </div>
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="client_email_2">E-mail 2</label>
                                    <input type="email" name="client_email_2"
                                           id="client_email_2"
                                           class="form-control form-control-sm"
                                           value="{{ old('client_email_2') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col-md-12 col-lg-6">
                                    <label for="country">Country</label>
                                    <select
                                        class="js-country-all form-control form-control-sm"
                                        multiple="multiple" name="country[]"
                                        id="country">
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-md-12 col-lg-6">
                                    <label for="nationality">Nationality</label>
                                    <select
                                        class="js-nationality-all form-control form-control-sm"
                                        multiple="multiple" name="nationality[]"
                                        id="nationality">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="lang">Languages</label>
                                <select
                                    class="js-language-all form-control form-control-sm"
                                    multiple="multiple" name="lang[]" id="lang">
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="row">
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status"
                                            class="form-control form-control-sm">
                                        <option value="" selected disabled> {{ __('-- Status --') }}
                                        </option>
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>New Lead
                                        </option>
                                        <option value="8" {{ old('status') == 8 ? 'selected' : '' }}>No Answer
                                        </option>
                                        <option value="12" {{ old('status') == 12 ? 'selected' : '' }}>In progress
                                        </option>
                                        <option value="3" {{ old('status') == 3 ? 'selected' : '' }}>Potential
                                            appointment
                                        </option>
                                        <option value="4" {{ old('status') == 4 ? 'selected' : '' }}>Appointment set
                                        </option>
                                        <option value="10" {{ old('status') == 10 ? 'selected' : '' }}>Appointment
                                            follow up
                                        </option>
                                        <option value="5" {{ old('status') == 5 ? 'selected' : '' }}>Sold</option>
                                        <option value="13" {{ old('status') == 13 ? 'selected' : '' }}>Unreachable
                                        </option>
                                        <option value="7" {{ old('status') == 7 ? 'selected' : '' }}>Not interested
                                        </option>
                                        <option value="11" {{ old('status') == 11 ? 'selected' : '' }}>Low budget
                                        </option>
                                        <option value="9" {{ old('status') == 9 ? 'selected' : '' }}>Wrong Number
                                        </option>
                                        <option value="14" {{ old('status') == 14 ? 'selected' : '' }}>Unqualified
                                        </option>
                                        <option value="15" {{ old('status') == 15 ? 'selected' : '' }}>Lost
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label
                                        for="priority">{{  __('Priority') }}</label>
                                    <select name="priority" id="priority"
                                            class="form-control form-control-sm">
                                        <option value="" selected> {{ __('-- Priority --') }}</option>
                                        <option
                                            value="1" {{ old('priority') == 1 ? 'selected' : '' }}>
                                            Low
                                        </option>
                                        <option
                                            value="2" {{ old('priority') == 2 ? 'selected' : '' }}>
                                            Medium
                                        </option>
                                        <option
                                            value="3" {{ old('priority') == 3 ? 'selected' : '' }}>
                                            High
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="budget">Budget</label>
                                    <select name="budget_request[]" id="budget"
                                            class="js-select2 form-control form-control-sm"
                                            multiple>
                                        <option value="1">Less then 50K</option>
                                        <option value="2">50K <> 100K</option>
                                        <option value="3">100K <> 150K</option>
                                        <option value="4">150K <> 200K</option>
                                        <option value="5">200K <> 300K</option>
                                        <option value="6">300K <> 400k</option>
                                        <option value="7">400k <> 500K</option>
                                        <option value="8">500K <> 600k</option>
                                        <option value="9">600K <> 1M</option>
                                        <option value="10">1M <> 2M</option>
                                        <option value="11">More then 2M</option>
                                    </select>
                                </div>
                                <div class="form-group form-group-sm col-md-12 col-lg-6">
                                    <label for="rooms_request">Request</label>
                                    <select name="rooms_request[]" id="rooms_request"
                                            class="js-select2 form-control form-control-sm"
                                            multiple>
                                        <option value="1">0 + 1</option>
                                        <option value="2">1 + 1</option>
                                        <option value="3">2 + 1</option>
                                        <option value="4">3 + 1</option>
                                        <option value="5">4 + 1</option>
                                        <option value="6">5 + 1</option>
                                        <option value="7">6 + 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="requirements">Requirement</label>
                                <select name="requirements_request[]"
                                        id="requirements"
                                        class="js-select2 form-control form-control-sm"
                                        multiple>
                                    <option value="1">Investments</option>
                                    <option value="2">Life style</option>
                                    <option value="3">Investments + Lif style
                                    </option>
                                    <option value="4">Citizenship</option>
                                </select>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="lang">{{ __('Flags') }}</label>
                                <select class="js-select2 custom-select custom-select-sm"
                                        multiple="multiple" name="flags[]" id="flags">
                                    @foreach($flags as $flag)
                                        <option value="{{ $flag->id }}">{{ $flag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="source">Source</label>
                                <select name="source" id="source"
                                        class="form-control form-control-sm">
                                    <option value="" selected disabled> -- Select
                                        source --
                                    </option>
                                    @foreach($sources as $source)
                                        <option
                                            value="{{ $source->id }}">{{ $source->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Note:</label>
                        <textarea name="description"
                                  class="summernote"
                                  id="description">{!! old('description') !!}</textarea>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit"
                                class="btn btn-primary">
                            Save <i class="icon-save"></i></button>
                        <a href="{{ route('clients.index') }}"
                           class="btn btn-warning">Cancel <i class="icofont icofont-ban"></i></a>
                    </div>
                </form>
                <!-- end of table col-lg-6 -->
            </div>
            <!-- personal card end-->
        </div>
    </div>
@endsection
