@extends('layouts.vertical.master')
@section('title', 'Leads')

@section('css')

@endsection

@section('style')
    <!-- Datatables.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterange-picker.css') }}">
@endsection

@section('script')
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/datepicker/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script>
    <script>
        $('#lead-table').DataTable();

        $("#cts_select").hide();
        $("#pts_select").hide();

        function valueChanged() {
            if ($('#country_check').is(":checked"))
                $("#cts_select").show();
            else
                $("#cts_select").hide();
        }

        function valuePhoneChanged() {
            if ($('#phone_check').is(":checked"))
                $("#pts_select").show();
            else
                $("#pts_select").hide();
        }

    </script>

@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Leads</li>
@endsection

@section('breadcrumb-title')
    <h3>Leads list</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-xl-3">
                <div class="card p-1">
                    <div class="card-header b-l-primary p-2">
                        <h6 class="m-0">Filter leads by:</h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="form-group mb-2">
                            <select class="form-control form-control-sm digits" id="status_filter">
                                <option value=""> Status</option>
                                <option value="1">New Lead</option>
                                <option value="8">No Answer</option>
                                <option value="12">In progress</option>
                                <option value="3">Potential appointment</option>
                                <option value="4">Appointment set</option>
                                <option value="10">Appointment follow up</option>
                                <option value="5">Sold</option>
                                <option value="13">Unreachable</option>
                                <option value="7">Not interested</option>
                                <option value="11">Low budget</option>
                                <option value="9">Wrong Number</option>
                                <option value="14">Unqualified</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <select class="form-control form-control-sm digits" id="source_filter">
                                <option value="">Source</option>
                                <option value="1">Facebook</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <select class="form-control form-control-sm digits" id="priority_filter">
                                <option value="">Priority</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input id="country_check" type="checkbox"
                                   onclick="valueChanged()">
                            <label for="country_check">Country</label>
                        </div>
                        <div class="form-group mb-2 ml-2" id="cts_select">
                            <select class="form-control form-control-sm digits mb-1" id="country_type">
                                <option value="">is</option>
                                <option value="1">isn't</option>
                                <option value="2">contains</option>
                                <option value="3">doesn't contain</option>
                                <option value="3">start with</option>
                                <option value="3">ends with</option>
                                <option value="3">is empty</option>
                                <option value="3">is note empty</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" placeholder="Type here"
                                   id="country_field">
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input id="phone_check" type="checkbox"
                                   onclick="valuePhoneChanged()">
                            <label for="phone_check">Phone</label>
                        </div>
                        <div class="form-group mb-2 ml-2" id="pts_select">
                            <select class="form-control form-control-sm digits mb-1" id="phone_type">
                                <option value="">is</option>
                                <option value="1">isn't</option>
                                <option value="2">contains</option>
                                <option value="3">doesn't contain</option>
                                <option value="3">start with</option>
                                <option value="3">ends with</option>
                                <option value="3">is empty</option>
                                <option value="3">is note empty</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" placeholder="Type here"
                                   id="phone_field">
                        </div>
                        <div class="form-group mb-2">
                            <select class="form-control form-control-sm digits" id="assigned_filter">
                                <option value="">Assigned</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Admin</option>
                                <option value="3">Manager</option>
                                <option value="3">User</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control form-control-sm" placeholder="Type here"
                                   id="last_active">
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input id="no_tasks" type="checkbox">
                            <label for="no_tasks">No tasks</label>
                        </div>
                        <div class="theme-form mb-2">
                            <input class="form-control form-control-sm digits" type="text" name="daterange"
                                   value="">
                        </div>
                        <div class="form-group">
                            <label class="d-block" for="edo-ani">
                                <input class="radio_animated" id="edo-ani" type="radio" name="rdo-ani"
                                       checked=""
                                       data-original-title="" title=""> Creation
                            </label>
                            <label class="d-block" for="edo-ani1">
                                <input class="radio_animated" id="edo-ani1" type="radio" name="rdo-ani"
                                       data-original-title="" title=""> Modification
                            </label>
                            <label class="d-block" for="edo-ani2">
                                <input class="radio_animated" id="edo-ani2" type="radio" name="rdo-ani"
                                       checked=""
                                       data-original-title="" title=""> Arrival
                            </label>
                            <label class="d-block" for="edo-ani13">
                                <input class="radio_animated" id="edo-ani13" type="radio" name="rdo-ani"
                                       data-original-title="" title=""> None
                            </label>
                        </div>
                    </div>
                    <div class="card-footer p-2">
                        <button class="btn btn-sm btn-primary" type="submit" data-original-title="" title="">
                            Filter
                        </button>
                        <button class="btn btn-sm btn-light" type="submit" data-original-title="" title="">Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
