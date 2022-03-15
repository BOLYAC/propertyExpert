@extends('layouts.vertical.master')
@section('title', '| edit agency')

@section('style_before')
    <!-- Summernote.css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- Datatables.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/notify/notify-script.js') }}"></script>
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Start Edit record
            let table = $('#res-config').DataTable();
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="col-6 pr-1 pl-1"><input type="text" name="projects[]" value=""/><a href="javascript:void(0);" class="ml-1 remove_button"><i class="fa fa-trash"></i></a></div>'; //New input field html
            var x = 1; //Initial field counter is 1

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
        });
    </script>
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">{{ __('Agencies') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit:') }} {{ $agency->title }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <form action="{{ route('agencies.update', $agency) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="title"
                                           id="title"
                                           value="{{ old('title', $agency->title) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="name"
                                           id="name"
                                           value="{{ old('name', $agency->name) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col-6">
                                    <label for="in_charge">{{ __('Owner') }}</label>
                                    <input class="form-control sm" type="text" name="in_charge" id="in_charge"
                                           value="{{ old('in_charge', $agency->in_charge) }}">
                                </div>
                                <div class="form-group input-group-sm col-6">
                                    <label for="tax_number">{{ __('Tax number') }}</label>
                                    <input class="form-control sm" type="text" name="tax_number" id="tax_number"
                                           value="{{ old('tax_number' , $agency->tax_number) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="phone">{{ __('Agency phone') }}</label>
                                    <input class="form-control sm" type="text" name="phone" id="phone"
                                           value="{{ old('phone', $agency->phone) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Agency email') }}</label>
                                    <input class="form-control sm" type="text" name="email" id="email"
                                           value="{{ old('email', $agency->email) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="commission_rate">{{ __('Commission rate') }}</label>
                                    <input class="form-control sm" type="text" name="commission_rate"
                                           id="commission_rate"
                                           value="{{ old('commission_rate' , $agency->commission_rate) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="contract_status">{{ __('Contract status') }}</label>
                                    <input class="form-control sm" type="text" name="contract_status"
                                           id="contract_status"
                                           value="{{ old('contract_status', $agency->contract_status) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="country">{{ __('Country') }}</label>
                                    <select name="country" id="country" class="form-control form-control-sm">
                                        <option value="">{{ __('Select country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                            <div class="form-group input-group-sm">
                                <label for="address">{{__('Address')}}</label>
                                <textarea class="summernote" type="text" name="address"
                                          id="address">{{ old('address',  $agency->address) }}</textarea>
                            </div>
                            <div class="form-group input-group-sm">
                                <label for="note">{{ __('Note') }}</label>

                                <textarea name="note"
                                          class="summernote"
                                          id="note">{{ old('note', $agency->note) }}</textarea>
                            </div>
                            <div class="col-form-label">
                                {{ __('Projects') }}
                            </div>
                            <div class="field_wrapper row">
                                @if(is_null($agency->projects))
                                    <div class="col-4 pr-1">
                                        <input type="text" name="projects[]" value=""/>
                                        <a href="javascript:void(0);" class="add_button"
                                           title="Add field"><i class="fa fa-plus-square"></i></a>
                                    </div>
                                @else
                                    @foreach($agency->projects as $project)
                                        @if($loop->first)
                                            <div class="col-6 pr-1 pl-1">
                                                <input type="text" name="projects[]"
                                                       value="{{ $project }}"/>
                                                <a href="javascript:void(0);" class="add_button"
                                                   title="Add field"><i
                                                        class="fa fa-plus-square"></i></a>
                                            </div>
                                        @else
                                            <div class="col-6 pr-1 pl-1">
                                                <input type="text" name="projects[]"
                                                       value="{{ $project }}"/><a
                                                    href="javascript:void(0);"
                                                    class="ml-1 remove_button"><i
                                                        class="fa fa-trash"></i></a></div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            {{--<div class="form-group">
                                <div class="border-checkbox-section pl-4">
                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                        <input class="border-checkbox" type="checkbox" id="status" name="status"
                                            {{ $agency->status == 1 ? 'checked' : '' }}>
                                        <label class="border-checkbox-label" for="status">{{ __('Status') }}</label>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ route('agencies.index') }}"
                               class="btn btn-sm btn-warning">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body b-t-primary">
                        <div class="table-responsive">
                            <table id="res-config" class="display"
                                   style="width:100%">
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
                                                <span class="badge badge-light-primary">{{ __('New Lead') }}</span>
                                                @break
                                                @case(8)
                                                <span class="badge badge-light-primary">{{ __('No Answer') }}</span>
                                                @break
                                                @case(12)
                                                <span
                                                    class="badge badge-light-primary">{{ __('In progress') }}</span>
                                                @break
                                                @case(3)
                                                <span class="badge badge-light-primary">{{ __('Potential
                            appointment') }}</span>
                                                @break
                                                @case(4)
                                                <span class="badge badge-light-primary">{{ __('Appointment
                            set') }}</span>
                                                @break
                                                @case(10)
                                                <span class="badge badge-light-primary">{{ __('Appointment
                            follow up') }}</span>
                                                @break
                                                @case(5)
                                                <span class="badge badge-light-success">{{ __('Sold') }}</span>
                                                @break
                                                @case(13)
                                                <span
                                                    class="badge badge-light-warning">{{ __('Unreachable') }}</span>
                                                @break
                                                @case(7)
                                                <span
                                                    class="badge badge-light-danger">{{ __('Not interested') }}</span>
                                                @break
                                                @case(11)
                                                <span
                                                    class="badge badge-light-warning">{{ __('Low budget') }}</span>
                                                @break
                                                @case(9)
                                                <span
                                                    class="badge badge-light-danger">{{ __('Wrong Number') }}</span>
                                                @break
                                                Unqualified
                                                @case(14)
                                                <span
                                                    class="badge badge-light-danger">{{ __('Wrong Number') }}</span>
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
            <!-- Zero config.table end -->
        </div>
    </div>

@endsection
