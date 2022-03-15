@extends('layouts.vertical.master')
@section('title', '| Agency edit')

@section('style_before')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/todo.css') }}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
@endsection

@section('style')

@endsection

@section('script')

    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/notify/notify-script.js') }}"></script>
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/buttons.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.colReorder.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.rowReorder.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            // Start Edit record
            let table = $('#res-config').DataTable();

            //Welcome Message (not for login page)
            function notify(title, message, type, icon) {
                $.notify({
                        icon: icon,
                        title: title,
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

            window.livewire.on('alert', param => {
                notify(param['type'], param['message'], param['icon'])
            })
            // Add Proect name fields
            let maxField = 10; //Input fields increment limitation
            let addButton = $('.add_button'); //Add button selector
            let wrapper = $('.field_wrapper'); //Input field wrapper
            let fieldHTML = '<div class="col-3 pr-1 pl-1"><input type="text" name="projects[]" value=""/><a href="javascript:void(0);" class="ml-1 remove_button"><i class="fa fa-trash"></i></a></div>'; //New input field html
            let x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function () {
                console.log('clicked')
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function (e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
            // Add sells Representative fields
            var maxGroup = 3;
            var i = $('body').find('.field_wrapper_copy').length;

            //add more fields group
            $(".add_button_rep").click(function () {
                if ($('body').find('.field_wrapper_copy').length < maxGroup) {
                    ++i;
                    let fieldHTML = `<div class="field_wrapper_copy row">
                        <div class="form-group input-group-sm col-6">
                        <label>{{ __('Representative') }}</label>
                        <input type="text" name="representatives[${i}][key]" class="form-control sm" value="">
                        </div>
                        <div class="form-group input-group-sm col">
                        <label>{{ __('Rep phone') }}</label>
                        <input type="text" name="representatives[${i}][value]" class="form-control sm" value="">
                        </div>
                        <div class="col-1 m-auto p-auto">
                        <a href="javascript:void(0);" class="btn btn-xs btn-warning remove_button_rep"><i class="fa fa-trash"></i></a>
                        </div></div>`
                    //$('body').find('.fieldGroup:last').after(fieldHTML);
                    $('.field_wrapper_rep').append(fieldHTML); //Add field html
                } else {
                    alert('Maximum ' + maxGroup + ' groups are allowed.');
                }
            });

            //remove fields group
            $("body").on("click", ".remove_button_rep", function () {
                $(this).parents(".field_wrapper_copy").remove();
            });
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}"></a>{{ __('Agencies list') }}</li>
    <li class="breadcrumb-item">{{ __('Agencies list') }}</li>
@endsection

@section('breadcrumb-title')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <!-- tab header start -->
                <div class="card">
                    <div class="row product-page-main">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab"
                                                        href="#top-home" role="tab" aria-controls="top-home"
                                                        aria-selected="false">{{ __('Information') }}</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-toggle="tab"
                                                        href="#top-profile" role="tab" aria-controls="top-profile"
                                                        aria-selected="false">{{ __('Tasks & Notes') }}</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                                        href="#top-contact" role="tab" aria-controls="top-contact"
                                                        aria-selected="true">{{ __('Documents') }}</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="brand-top-tab" data-toggle="tab"
                                                        href="#top-brand" role="tab" aria-controls="top-brand"
                                                        aria-selected="true">{{ __('Clients') }}</a>
                                    <div class="material-border"></div>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade active show" id="top-home" role="tabpanel"
                                     aria-labelledby="top-home-tab">
                                    <div class="card pt-2">
                                        <form action="{{ route('agencies.update', $agency) }}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="company_type">{{ __('Type') }}</label>
                                                        <select name="company_type" id="company_type"
                                                                class="form-control form-control-sm">
                                                            <option
                                                                value="1" {{ old('type', $agency->company_type) == 1 ? 'selected' : '' }}>
                                                                {{ __('Company') }}
                                                            </option>
                                                            <option
                                                                value="2" {{ old('type', $agency->company_type) == 2 ? 'selected' : '' }}>
                                                                {{ __('Freelance') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="name">{{ __('Name') }}</label>
                                                        <input class="form-control form-control-sm" type="text"
                                                               name="name"
                                                               id="name"
                                                               value="{{ old('name', $agency->name) }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="in_charge">{{ __('Owner') }}</label>
                                                        <input class="form-control sm" type="text" name="in_charge"
                                                               id="in_charge"
                                                               value="{{ old('in_charge', $agency->in_charge) }}">
                                                    </div>
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="tax_number">{{ __('Tax number') }}</label>
                                                        <input class="form-control sm" type="text" name="tax_number"
                                                               id="tax_number"
                                                               value="{{ old('tax_number' , $agency->tax_number) }}">
                                                    </div>
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="tax_branch">{{ __('Tax branch') }}</label>
                                                        <input class="form-control sm" type="text" name="tax_branch"
                                                               id="tax_number"
                                                               value="{{ old('tax_branch' , $agency->tax_branch) }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="phone">{{ __('Agency phone') }}</label>
                                                        <input class="form-control sm" type="text" name="phone"
                                                               id="phone"
                                                               value="{{ old('phone', $agency->phone) }}">
                                                    </div>
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="email">{{ __('Agency email') }}</label>
                                                        <input class="form-control sm" type="text" name="email"
                                                               id="email"
                                                               value="{{ old('email', $agency->email) }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group-addon float-right">
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-sm btn-success add_button_rep">
                                                        <span class="fa fa-plus" aria-hidden="true">
                                                        </span> {{ __('Add representatives') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field_wrapper_rep">
                                                    @if(!is_null($agency->representatives))
                                                        @for ($i = 0; $i < count($agency->representatives); $i++)
                                                            <div class="field_wrapper_copy row">
                                                                <div class="form-group input-group-sm col-6">
                                                                    <label>{{ __('Representative') }}</label>
                                                                    <input type="text"
                                                                           name="representatives[{{$i}}][key]"
                                                                           class="form-control sm"
                                                                           value="{{ $agency->representatives[$i]['key'] ?? '' }}">
                                                                </div>
                                                                <div class="form-group input-group-sm col">
                                                                    <label>{{ __('Rep phone') }}</label>
                                                                    <input type="text"
                                                                           name="representatives[{{$i}}][value]"
                                                                           class="form-control sm"
                                                                           value="{{ $agency->representatives[$i]['value'] ?? '' }}">
                                                                </div>
                                                                <div class="col-1 m-auto p-auto">
                                                                    <a href="javascript:void(0);"
                                                                       class="btn btn-xs btn-warning remove_button_rep"><i
                                                                            class="fa fa-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="commission_rate">{{ __('Commission rate') }}</label>
                                                        <input class="form-control sm" type="text"
                                                               name="commission_rate"
                                                               id="commission_rate"
                                                               value="{{ old('commission_rate' , $agency->commission_rate) }}">
                                                    </div>
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="contract_status">{{ __('Contract status') }}</label>
                                                        <input class="form-control sm" type="text"
                                                               name="contract_status"
                                                               id="contract_status"
                                                               value="{{ old('contract_status', $agency->contract_status) }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group input-group-sm col">
                                                        <label for="country">{{ __('Country') }}</label>
                                                        <select name="country" id="country"
                                                                class="form-control form-control-sm">
                                                            <option value="">{{ __('Select country') }}</option>
                                                            @foreach($countries as $country)
                                                                <option
                                                                    value="{{ $country->id }}" {{ $country->id == $agency->country ? 'selected' : '' }}>
                                                                    {{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm col">
                                                        <label for="city">{{ __('City') }}</label>
                                                        <input class="form-control sm" type="text" name="city"
                                                               id="city"
                                                               value="{{ old('city', $agency->city) }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="address">{{__('Address')}}</label>
                                                        <textarea class="summernote" type="text" name="address"
                                                                  id="address">{{ old('address',  $agency->address) }}</textarea>
                                                    </div>
                                                    <div class="form-group input-group-sm col-md">
                                                        <label for="note">{{ __('Note') }}</label>

                                                        <textarea name="note"
                                                                  class="summernote"
                                                                  id="note">{{ old('note', $agency->note) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-form-label">
                                                    {{ __('Projects') }}
                                                </div>
                                                <div class="field_wrapper row">
                                                    @if(is_null($agency->projects))
                                                        <div class="col-3 pr-1">
                                                            <input type="text" name="projects[]" value=""/>
                                                            <a href="javascript:void(0);" class="add_button"
                                                               title="Add field"><i class="fa fa-plus-square"></i></a>
                                                        </div>
                                                    @else
                                                        @foreach($agency->projects as $project)
                                                            @if($loop->first)
                                                                <div class="col-3 pr-1 pl-1">
                                                                    <input type="text" name="projects[]"
                                                                           value="{{ $project }}"/>
                                                                    <a href="javascript:void(0);" class="add_button"
                                                                       title="Add field"><i
                                                                            class="fa fa-plus-square"></i></a>
                                                                </div>
                                                            @else
                                                                <div class="col-3 pr-1 pl-1">
                                                                    <input type="text" name="projects[]"
                                                                           value="{{ $project }}"/><a
                                                                        href="javascript:void(0);"
                                                                        class="ml-1 remove_button"><i
                                                                            class="fa fa-trash"></i></a></div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>

                                                {{--
                                                <div class="form-group">
                                                    <div class="col-sm-12 col-xl-4 m-b-30 checkbox">
                                                        <input name="status" type="checkbox" id="checkbox1" {{ $agency->status == 1 ? 'checked' : '' }}/>
                                                        <label for="checkbox1">{{ __('Active') }}</label>
                                                    </div>
                                                </div>
                                                --}}
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    {{__('save')}}
                                                    <i class="icon-save"></i></button>
                                                <a href="{{ route('agencies.index') }}"
                                                   class="btn btn-sm btn-warning">{{ __('Cancel') }}</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="top-profile" role="tabpanel"
                                     aria-labelledby="profile-top-tab">
                                    @include('agencies.partials.task-note')
                                </div>
                                <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                     aria-labelledby="contact-top-tab">
                                    @include('agencies.partials.documents')
                                </div>
                                <div class="tab-pane fade" id="top-brand" role="tabpanel"
                                     aria-labelledby="brand-top-tab">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <div class="dt-responsive table-responsive">
                                                    <table id="res-config"
                                                           class="table table-bordered nowrap display compact">
                                                        <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>{{ __('Name') }}</th>
                                                            <th>{{ __('Status') }}</th>
                                                            <th>{{ __('Assigned') }}</th>
                                                            <th>{{ __('Source') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($agency->clients as $client)
                                                            <tr>
                                                                <td>{{ $client->public_id }}</td>
                                                                <td>
                                                                    <a href="{{ route('clients.edit', $client) }}">{{ $client->full_name }}</a>
                                                                </td>
                                                                <td>
                                                                    @switch($client->status)
                                                                        @case(1)
                                                                        <span
                                                                            class="badge badge-default">{{ __('New Lead') }}</span>
                                                                        @break
                                                                        @case(8)
                                                                        <span
                                                                            class="badge badge-default">{{ __('No Answer') }}</span>
                                                                        @break
                                                                        @case(12)
                                                                        <span
                                                                            class="badge badge-default">{{ __('In progress') }}</span>
                                                                        @break
                                                                        @case(3)
                                                                        <span class="badge badge-default">{{ __('Potential
                            appointment') }}</span>
                                                                        @break
                                                                        @case(4)
                                                                        <span class="badge badge-default">{{ __('Appointment
                            set') }}</span>
                                                                        @break
                                                                        @case(10)
                                                                        <span class="badge badge-default">{{ __('Appointment
                            follow up') }}</span>
                                                                        @break
                                                                        @case(5)
                                                                        <span
                                                                            class="badge badge-default">{{ __('Sold') }}</span>
                                                                        @break
                                                                        @case(13)
                                                                        <span
                                                                            class="badge badge-default">{{ __('Unreachable') }}</span>
                                                                        @break
                                                                        @case(7)
                                                                        <span
                                                                            class="badge badge-default">{{ __('Not interested') }}</span>
                                                                        @break
                                                                        @case(11)
                                                                        <span
                                                                            class="badge badge-default">{{ __('Low budget') }}</span>
                                                                        @break
                                                                        @case(9)
                                                                        <span
                                                                            class="badge badge-default">{{ __('Wrong Number') }}</span>
                                                                        @break
                                                                        @case(14)
                                                                        <span
                                                                            class="badge badge-danger">{{ __('Unqualified') }}</span>
                                                                        @break
                                                                    @endswitch
                                                                </td>
                                                                <td><span
                                                                        class="badge badge-success">{{ $client->user->name ?? '' }}</span>
                                                                </td>
                                                                <td>{{ optional($client->source)->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- tab header end -->
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('Owned by') }}</h5>
                    </div>
                    <div class="card-body pl-2 pr-2 pt-4">
                        <div class="inbox">
                            <div class="media active">
                                <div class="media-size-email">
                                    <img class="mr-3 rounded-circle"
                                         src="{{ asset('/assets/images/user/user.png') }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $agency->user->name ?? '' }}</h6>
{{--                                    <p>{{ $agency->user->roles->first()->name ?? ''}}</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('History') }}</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ __('Modified By:') }} </h6>
                        <p>{{ $agency->updateBy->name }}</p>
                        <h6>{{ __('Created time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($agency->created_at)->format('Y-m-d H:m') }}
                        </p>
                        <h6>{{ __('Modified time:') }} </h6>
                        <p>
                            {{ Carbon\Carbon::parse($agency->updated_at)->format('Y-m-d H:m') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
