@extends('layouts.vertical.master')
@section('title', '| New user')

@section('style_before')
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/notify/notify-script.js') }}"></script>
    <script>
        //Welcome Message (not for login page)
        function notify(message, type, icon) {
            $.notify({
                    icon: icon,
                    message: message
                },
                {
                    type: type,
                    allow_dismiss: false,
                    newest_on_top: false,
                    mouse_over: false,
                    showProgressbar: false,
                    spacing: 10,
                    timer: 2000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 30,
                        y: 30
                    },
                    delay: 1000,
                    z_index: 10000,
                    animate: {
                        enter: 'animated bounce',
                        exit: 'animated bounce'
                    },
                });
        }

        $('.js-language-all').select2({
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

        $('.js-select2-sales').select2({
            ajax: {
                url: "{{ route('users.fetch') }}",
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
        $('.js-select2-owner').select2({
            ajax: {
                url: "{{ route('users.fetch') }}",
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

        $('.js-select2').select2();
    </script>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Agency') }}</a></li>
    <li class="breadcrumb-item">{{ __('Transfer to deal') }}</li>
@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="card card-with-border">
                    <div class="card-header">
                        <h5>{{ __('Transfer to lead') }}</h5>
                    </div>
                    <form action="{{ route('agencyToDeal.transfer') }}" method="post" role="form">
                        @csrf
                        <div class="card-body">
                            <!-- Smart Wizard start-->
                            <div class="col-sm-12 pl-0">
                                <input type="hidden" name="leadId" value="{{$lead->id}}">
                                <div class="form-group">
                                    <label for="customer_name">{{ __('Customer name') }}</label>
                                    <input class="form-control" id="customer_name" name="customer_name" type="text"
                                           placeholder="{{ __('Customer name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="customer_passport_id">{{ __('Customer passport ID') }}</label>
                                    <input class="form-control" name="customer_passport_id" id="customer_passport_id"
                                           type="text" placeholder="{{ __('Customer passport ID') }}">
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone">{{ __('Customer phone') }}</label>
                                    <input class="form-control digits" name="customer_phone" id="customer_phone"
                                           type="number" placeholder="00905314300720">
                                </div>
                                <div class="form-group input-group-sm">
                                    <label for="inCharge">{{ __('Assign owner') }}</label>
                                    <select class="js-select2-owner form-control form-control-sm" name="inCharge"
                                            id="inCharge">
                                    </select>
                                </div>
                                <div class="form-group input-group-sm">
                                    <label for="share_with">{{ __('Sell representative') }}</label>
                                    <select class="js-select2-sales form-control form-control-sm"
                                            multiple="multiple" name="share_with[]" id="share_with">
                                    </select>
                                </div>
                                <div class="form-group input-group-sm">
                                    <label for="lang">{{ __('Languages') }}</label>
                                    <select class="js-language-all form-control form-control-sm"
                                            multiple="multiple" name="lang[]" id="lang">

                                    </select>
                                </div>
                                <div class="form-group input-group-sm">
                                    <label for="budget">{{ __('Budget') }}</label>
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
                            </div>
                            <!-- Smart Wizard Ends-->
                        </div>
                        <div class="card-footer m-2 p-2">
                            <div class="form-group row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                                    <a type="button" class="btn btn-sm btn-success">{{ __('Skip') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection
