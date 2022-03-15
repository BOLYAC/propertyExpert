@extends('layouts.vertical.master')
@section('title', '| Deal Edit')
@section('style_before')
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
    <!-- ToDo css -->
    <link rel="stylesheet" href="{{ asset('assets/css/todo.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- Datatables.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .jconfirm.jconfirm-supervan .jconfirm-box div.jconfirm-content {
            overflow: hidden
        }
    </style>

@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Plugins JS start-->
    <!-- Datatables.js -->
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        })
        let budgetData = [
            {id: 1, text: 'Less then 50K'},
            {id: 2, text: '50K <> 100K'},
            {id: 3, text: '100K <> 150K'},
            {id: 4, text: '150K <> 200K'},
            {id: 5, text: '200K <> 300K'},
            {id: 6, text: '300K <> 400k'},
            {id: 7, text: '400k <> 500K'},
            {id: 8, text: '500K <> 600k'},
            {id: 9, text: '600K <> 1M'},
            {id: 10, text: '1M <> 2M'},
            {id: 11, text: 'More then 2M'}
        ]

        $('.js-budgets-all').select2({
            data: budgetData,
        })

        $(".js-select2-sales").select2();
        $('.js-event-sells').select2();
        // Start Edit record
        let table = $('#res-config').DataTable({
            order: [[1, 'desc']],
        });

        // Init notification
        function notify(title, type) {
            $.notify({
                    title: title
                },
                {
                    type: type,
                    allow_dismiss: true,
                    newest_on_top: true,
                    mouse_over: true,
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
                    }
                });
        }

        $("#stage_id").on('change', function (e) {
            e.preventDefault();
            let level = $(this).val();
            let lead_id = '{{ $lead->id }}';
            if (level == 4) {
                $.confirm({
                    title: '{{ __('Reservation From') }}',
                    theme: 'supervan',
                    columnClass: 'col-md-12',
                    bootstrapClasses: {
                        container: 'container',
                        containerFluid: 'container-fluid',
                        row: 'row',
                    },
                    content: '' +
                        '<form class="reservationForm" enctype="multipart/form-data">' +
                        '@csrf' +
                        '<div class="row">' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Project name') }} </label>' +
                        '<input id="project" name="project_name" class="project_name form-control form-control-sm">' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Country') }} </label>' +
                        '<input type="text" class="country_province form-control form-control-sm" name="country_province"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Flat Num') }} </label>' +
                        '<input type="text" class="flat_num form-control form-control-sm" name="flat_num"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Gross M²') }} </label>' +
                        '<input type="text" class="gross_square form-control form-control-sm" name="gross_square"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Section/Plot') }} </label>' +
                        '<input type="text" class="section_plot form-control form-control-sm" name="section_plot"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Block Num') }} </label>' +
                        '<input type="text" class="block_num form-control form-control-sm" name="block_num"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Floor Num') }} </label>' +
                        '<input type="text" class="floor_number form-control form-control-sm" name="floor_number"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Num of Rooms') }} </label>' +
                        '<input type="text" class="room_number form-control form-control-sm" name="room_number"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Reservation amount') }} </label>' +
                        '<input type="text" class="reservation_amount form-control form-control-sm" name="reservation_amount"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Sale Price') }} </label>' +
                        '<input type="text" class="sale_price form-control form-control-sm" name="sale_price"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Down payment') }} </label>' +
                        '<input type="text" class="down_payment form-control form-control-sm" name="down_payment"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Payment type') }} </label>' +
                        '<select name="payment_type" class="payment_type form-control form-control-sm">' +
                        '<option value="">--  --</option>' +
                        '<option value="1">{{ __('Cash') }}</option>' +
                        '<option value="2">{{ __('Installment') }}</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('Discount') }} </label>' +
                        '<input type="text" class="payment_discount form-control form-control-sm" name="payment_discount"/>' +
                        '</div>' +
                        '<div class="form-group col-md-6">' +
                        '<label> {{ __('File upload') }} </label>' +
                        '<input type="file" class="file_path form-control form-control-sm" name="file_path"/>' +
                        '</div>' +
                        '<div class="form-group col-md-12">' +
                        '<label> {{ __('Note') }} </label>' +
                        '<textarea type="text" class="excerpt form-control form-control-sm" name="excerpt"/></textarea>' +
                        '</div>' +
                        '</div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                let name = this.$content.find('.project_name').val();
                                if (!name) {
                                    $.alert('provide a valid Project name');
                                    return false;
                                }
                                let project_name = this.$content.find('.project_name').val();
                                let country_province = this.$content.find('.country_province').val();
                                let flat_num = this.$content.find('.flat_num').val();
                                let gross_square = this.$content.find('.gross_square').val();
                                let section_plot = this.$content.find('.section_plot').val();
                                let block_num = this.$content.find('.block_num').val();
                                let floor_number = this.$content.find('.floor_number').val();
                                let room_number = this.$content.find('.room_number').val();
                                let reservation_amount = this.$content.find('.reservation_amount').val();
                                let sale_price = this.$content.find('.sale_price').val();
                                let file_path = this.$content.find('.file_path').val();
                                let excerpt = this.$content.find('.excerpt').val();
                                let down_payment = this.$content.find('.down_payment').val();
                                let payment_type = this.$content.find('.payment_type').val();
                                let payment_discount = this.$content.find('.payment_discount').val();
                                let lead_id = '{{ $lead->id }}'
                                $.ajax({
                                    url: "{{ route('deal.reservation.form') }}",
                                    type: "POST",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        lead_id,
                                        project_name,
                                        country_province,
                                        flat_num,
                                        gross_square,
                                        section_plot,
                                        floor_number,
                                        block_num,
                                        room_number,
                                        reservation_amount,
                                        sale_price,
                                        file_path,
                                        excerpt,
                                        down_payment,
                                        payment_type,
                                        payment_discount
                                    },
                                    success: function () {
                                        location.href = "{{ route('leads.show', $lead) }}"
                                        notify('Reservation created, Stage change to reservation', 'success');
                                    },
                                    error: function () {
                                        notify('Ops!! Something wrong', 'danger');
                                    },
                                });
                            }
                        },
                        cancel: function () {
                            $("#stage_id").val({{ $lead->stage_id }});
                        },
                    },
                    onContentReady: function () {
                        // Get properties
                        let unit_type = this.$content.find('.flat_num');
                        let gross_sqm = this.$content.find('.gross_square');
                        let flat_type = this.$content.find('.floor_number');
                        let country_province = this.$content.find('.country_province');
                        let proj = this.$content.find('.project_id')
                        let property = this.$content.find('.property')
                        // List properties
                        proj.on('change', function (e) {
                            e.preventDefault();
                            let projectID = $(this).val();
                            if (projectID) {
                                $.ajax({
                                    url: '/project/single-project/' + projectID,
                                    type: "GET",
                                    dataType: "json",
                                    success: function (data) {
                                        country_province.empty();
                                        country_province.val(data);
                                    }
                                });
                                $.ajax({
                                    url: '/project/get-properties/' + projectID,
                                    type: "GET",
                                    dataType: "json",
                                    success: function (data) {
                                        property.empty();
                                        property.append('<option value="">-- {{ __('Select Property') }} --</option>');
                                        $.each(data, function (key, value) {
                                            property.append('<option value="' + key + '">' + value + '</option>');
                                        });
                                    }
                                });
                            } else {
                                property.empty();
                            }
                        });
                        // get single project
                        property.on('change', function (e) {
                            e.preventDefault();
                            let propertyID = $(this).val();
                            if (propertyID) {
                                $.ajax({
                                    url: '/properties/single-property/' + propertyID,
                                    type: "GET",
                                    dataType: "json",
                                    success: function (data) {

                                        unit_type.empty();
                                        gross_sqm.empty();
                                        flat_type.empty();
                                        unit_type.val(data[0]['unit_type']);
                                        gross_sqm.val(data[0]['gross_sqm']);
                                        flat_type.val(data[0]['flat_type']);
                                    }
                                });
                            } else {
                                property.empty();
                            }
                        });
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            } else {

                $.ajax({
                    type: 'POST',
                    url: '{{ route('stage.change') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        stage_id: level,
                        lead_id: lead_id
                    },
                    success: function (r) {
                        if (level >= 7) {
                            $('#stage_id_shown').removeClass("invisible").addClass("visible")
                        } else {
                            $('#stage_id_shown').removeClass("visible").addClass("invisible")
                        }
                        notify('Stage changed', 'success');
                    }
                    , error: function (error) {
                        notify('Ops!! Something wrong', 'danger');
                    }
                });
            }

        });
        $("#expertise_report").on('change', function (e) {
            e.preventDefault();
            if (confirm('Are you sure?')) {
                let reportCheck = ($(this).prop("checked") === true ? '1' : 0)
                let lead_id = '{{ $lead->id }}';
                $.ajax({
                    type: 'POST',
                    url: '{{ route('lead.apply.expert_report') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        reportCheck,
                        lead_id
                    },
                    success: function (r) {
                        notify('Expertise report confirmed', 'success');
                    }
                    , error: function (error) {
                        notify('Ops!! Something wrong', 'danger');
                    }
                });
            } else {
                return false;
            }
        })
        $("#title_deed").on('change', function (e) {
            e.preventDefault();
            if (confirm('Are you sure?')) {
                let titleCheck = ($(this).prop("checked") === true ? 1 : 0)
                let lead_id = '{{ $lead->id }}';
                $.ajax({
                    type: 'POST',
                    url: '{{ route('lead.apply.title_deed') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        titleCheck,
                        lead_id
                    },
                    success: function (r) {
                        notify('Title deed confirmed', 'success');
                    }
                    , error: function (error) {
                        notify('Ops!! Something wrong', 'danger');
                    }
                });
            } else {
                return false;
            }
        })
        $('#trans-to-sales').on('submit', function (e) {
            e.preventDefault();
            user_id = $('#inCharge').val();
            lead_id = '{{ $lead->id }}';
            $.ajax({
                url: "{{route('deal.change.owner')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    lead_id: lead_id,
                },
                success: function () {
                    notify('Deal transferred successfully', 'success');
                },
                error: function (response) {
                    notify('Ops something is wrong!', 'danger');
                },
            });
        });
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">{{ __('Deals') }}</a></li>
    <li class="breadcrumb-item">{{ __('Deal name') }}: {{ $lead->client->full_name ?? $lead->full_name }}</li>
@endsection

@section('content')
    <!-- Main-body start -->
    <div class="container-fluid">
        @include('partials.flash-message')
        <div class="row">
            <div class="col-md-8">
                <div class="card card-with-border">
                    <div class="card-header b-t-primary b-b-primary p-2 row justify-content-between">
                        <div class="col-md-4 col-lg-4">
                            @if($lead->invoice_id <> 0)
                                <span class="badge badge-success">{{ __('Deal Won') }}</span>
                            @else
                                <div>
                                    <select name="stage_id" id="stage_id"
                                            class="custom-select custom-select-sm">
                                        <option
                                            value="1" {{ old('stage_id', $lead->stage_id) == 1 ? 'selected' : '' }}>
                                            {{ __('In contact') }}
                                        </option>
                                        <option
                                            value="2" {{ old('stage_id', $lead->stage_id) == 2 ? 'selected' : '' }}>
                                            {{ __('Appointment Set') }}
                                        </option>
                                        @can('deal-stage')
                                            <option
                                                value="3" {{ old('stage_id', $lead->stage_id) == 3 ? 'selected' : '' }}>
                                                {{ __('Follow up') }}
                                            </option>
                                            <option
                                                value="4" {{ old('stage_id', $lead->stage_id) == 4 ? 'selected' : '' }}>
                                                {{ __('Reservation') }}
                                            </option>
                                            <option
                                                value="5" {{ old('stage_id', $lead->stage_id) == 5 ? 'selected' : '' }}>
                                                {{ __('contract signed') }}
                                            </option>
                                            <option
                                                value="6" {{ old('stage_id', $lead->stage_id) == 6 ? 'selected' : '' }}>
                                                {{ __('Down payment') }}
                                            </option>
                                            <option
                                                value="7" {{ old('stage_id', $lead->stage_id) == 7 ? 'selected' : '' }}>
                                                {{ __('Developer invoice') }}
                                            </option>
                                            <option
                                                value="8" {{ old('stage_id', $lead->stage_id) == 8 ? 'selected' : '' }}>
                                                {{ __('Won Deal') }}
                                            </option>
                                        @endcan
                                        <option
                                            value="9" {{ old('stage_id', $lead->stage_id) == 9 ? 'selected' : '' }}>
                                            {{ __('Lost') }}
                                        </option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 col-lg-8">
                            @if($lead->invoice_id <> 0)
                            @else
                                @can('transfer-deal-to-invoice')
                                    <div id="stage_id_shown"
                                         class="{{ $lead->stage_id >= 7 ? 'visible': 'invisible' }}">
                                        <form action="{{ route('lead.convert.order', $lead) }}"
                                              onSubmit="return confirm('Are you sure?');"
                                              method="post" class="pull-right">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                            >{{ __('Convert to invoice') }} <i class="ti-money"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                                @can('client-appointment')
                                    <div>
                                        <button
                                            class="btn btn-primary btn-sm pull-right mr-2"
                                            data-toggle="modal"
                                            data-target="#sign-in-modal">{{ __('Make appointment') }} <i
                                                class="ti-alarm-clock"></i></button>
                                    </div>
                                @endcan
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                <div class="checkbox checkbox-dark">
                                    <input id="expertise_report" name="expertise_report" type="checkbox"
                                        {{ $lead->expertise_report == 1 ? 'checked' : '' }}>
                                    <label for="expertise_report">{{ __('expertise report') }}</label>
                                </div>
                                <div class="checkbox checkbox-dark">
                                    <input id="title_deed" name="title_deed" type="checkbox"
                                        {{ $lead->title_deed == 1 ? 'checked' : null }}>>
                                    <label for="title_deed">{{ __('Title deed') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($lead->origin_type === 'App\Agency')
                    @include('leads.partials.agency-lead', ['agency' => $lead])
                @else
                    @include('partials.lead-info', ['client' => $lead])
                @endif
                @include('partials.comments', ['subject' => $lead])
                @include('partials.events', ['subject' => $lead])
                @include('leads.partials.reservation')
                @if($lead->invoices()->exists())
                    <div class="col-xl-5 xl-100 box-col-6">
                        <div class="card card-with-border">
                            <div class="card-header">
                                <h5>{{ __('Invoice history') }}</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive groups-table agent-performance-table">
                                    <table class="table">
                                        <tbody>
                                        @foreach($lead->invoices as $invoice)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle"><img
                                                            class="img-radius img-40 align-top m-r-15 rounded-circle"
                                                            src="{{ asset('storage/' . $invoice->user->image_path) }}"
                                                            alt="">
                                                        <div class="d-inline-block"><span
                                                                class="f-w-600">{{ $invoice->user->name }}</span><span
                                                                class="d-block f-12 font-primary">{{ $invoice->user->roles->first()->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('invoices.show', $invoice) }}"
                                                           class="f-w-700">
                                                            {{ $invoice->client_name ?? $invoice->client->full_name ??'' }}
                                                        </a>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn badge-light-primary btn-xs" type="button">
                                                        {{ $invoices->project->project_name ?? $invoices->project_name ?? '' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card card-with-border">
                    <div class="card-header b-b-info">
                        <h5 class="text-muted">{{ __('Owned by') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="inbox">
                            <div class="media active">
                                <div class="media-size-email">
                                    <img class="mr-3 rounded-circle img-50"
                                         style="width: 50px;height:50px;"
                                         src="{{ asset('storage/' . $lead->user->image_path) }}"
                                         alt="">
                                </div>
                                <div class="media-body">
                                    <h6 class="font-primary">{{ $lead->user->name }}</h6>
                                    <p>{{ $lead->user->roles->first()->name }}</p>
                                </div>
                            </div>
                        </div>

                        <br>
                        @can('share-client')
                            <form id="trans-to-sales">
                                @csrf
                                <div class="form-group form-group-sm">
                                    <select class="form-control form-control-sm" name="inCharge" id="inCharge">
                                        @foreach($users as $user)
                                            <option
                                                value="{{ $user->id }}" {{ $lead->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary form-control form-control-sm">
                                    {{ __('Change') }} <i
                                        class="icon-share-alt"></i></button>
                            </form>
                        @endcan
                    </div>
                </div>
                @can('share-deal')
                    <div class="card card-with-border">
                        <div class="card-header b-b-primary">
                            <h6 class="text-muted">{{ __('sale(s) representative') }}</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{route('sales.shareLead')}}" method="POST" id="share_lead_with">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                    <select class="js-select2-sales form-control form-control-sm"
                                            name="share_with[]" id="share_with"
                                            multiple>
                                        @foreach($users as $user)
                                            @if($lead->ShareWithSelles->contains($user))
                                                <option value="{{ $user->id }}"
                                                        selected>{{ $user->name ?? '' }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ $user->name ?? ''}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary form-control form-control-sm">{{ __('Share') }}
                                    <i
                                        class="icon-share"></i></button>
                            </form>
                        </div>
                    </div>
                @endcan
                @include('leads.partials.task-note')
                @if($lead->stageLog()->exists())
                    <div class="card card-with-border">
                        <div class="card-header">
                            <h5 class="d-inline-block">{{ __('Stage activity') }}</h5>
                        </div>
                        <div class="card-body activity-social">
                            <ul>
                                @foreach($lead->stageLog as $log)
                                    <li class="border-recent-success">
                                        <small>{{ $log->created_at->format('Y-m-d H:i') }}</small>
                                        <p class="mb-0">{{ __('Stage change to') }}: <span
                                                class="f-w-800 text-primary">{{ $log->stage_name }}</span></p>
                                        <P>by <a href="#">{{ $log->user_name }}</a></P>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('New appointment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-2">
                        <input type="hidden" name="client_id" value="{{ $lead->client_id}}">
                        <input type="hidden" name="lead_id" value="{{ $lead->id}}">
                        <input type="hidden" name="user_id" value="{{ auth()->id()}}">
                        <div class="row">
                            <div class="form-group input-group-sm col-md-6">
                                <label for="name">{{ __('Title') }}</label>
                                <input class="form-control form-control-sm"
                                       type="text"
                                       name="name"
                                       id="name">
                            </div>
                            <div class="form-group input-group-sm col-md-6">
                                <label for="event_date">{{ __('Date of appointment') }}</label>
                                <input id="event_date"
                                       class="form-control form-control-sm"
                                       name="event_date"
                                       type="datetime-local"
                                       required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block" for="chk-ani">
                                <input class="checkbox_animated" id="chk-ani" type="checkbox"
                                       name="zoom_meeting">
                                Zoom meeting
                            </label>
                        </div>
                        <div class="form-group input-group-sm">
                            <label for="color">{{ __('Colors') }}</label>
                            <div>
                                <input id="color" name="color" type="color" value="#0B8043" list="presetColors">
                                <datalist id="presetColors">
                                    <option>#0B8043</option>
                                    <option>#D50000</option>
                                    <option>#F4511E</option>
                                    <option>#8E24AA</option>
                                    <option>#3F51B5</option>
                                    <option>#039BE5</option>
                                </datalist>
                            </div>
                        </div>
                        @can('share-appointment')
                            <div class="mb-2">
                                <div class="col-form-label">{{ __('Share with') }}</div>
                                <select name="share_with[]" class="js-event-sells custom-select custom-select-sm"
                                        multiple>
                                    @foreach($users as $user)
                                        @if($lead->ShareWithSelles->contains($user))
                                            <option value="{{ $user->id }}"
                                                    selected>{{ $user->name ?? '' }}</option>
                                        @else
                                            <option value="{{ $user->id }}">{{ $user->name ?? ''}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @endcan
                        <div class="form-group input-group-sm">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea type="text" name="description"
                                      id="description" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group input-group-sm">
                            <label for="place">{{ __('Place') }}</label>
                            <input class="form-control form-control-sm" type="text" name="place" id="place">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                                onClick="this.form.submit(); this.disabled=true; this.value='Sending…';">{{ __('Save') }}
                            <i
                                class="ti-save-alt"></i></button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Appointment Modal -->
@endsection

