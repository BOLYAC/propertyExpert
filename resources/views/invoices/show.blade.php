@extends('layouts.vertical.master')
@section('title', '| Sales page')
@section('style_before')
    <!-- Datatables.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <style>
        .select2-container--open {
            z-index: 999999999999999 !important;
        }
    </style>
@endsection

@section('script')
    <!-- Datatables.js -->
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <script>
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

        $("#commissionSelect input[type='radio']").change(function (e) {
            // this will contain a reference to the checkbox
            e.preventDefault();
            if (this.checked) {
                let title = $(this).val()
                let invoice_id = '{{ $invoice->id }}';
                console.log(invoice_id)
                $.ajax({
                    type: 'POST',
                    url: '{{ route('change.commission_stat') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        title,
                        invoice_id
                    },
                    success: function (r) {
                        notify('Update commission status', 'success');
                    }
                    , error: function (error) {
                        notify('Ops!! Something wrong', 'danger');
                    }
                });
            } else {
                // the checkbox is now no longer checked
            }
        });

        $("#status").on('change', function (e) {
            e.preventDefault();
            let level = $(this).val();
            let invoice_id = '{{ $invoice->id }}';
            if (level) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('invoice.status.change') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: level,
                        invoice_id: invoice_id
                    },
                    success: function (r) {
                        notify('Stage changed', 'success');
                    }
                    , error: function (error) {
                        notify('Ops!! Something wrong', 'danger');
                    }
                });
            }
        });
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">{{ __('Sales list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Sales page') }}</li>
    <li class="breadcrumb-item">{{ __('Lead name') }}: <p class="f-w-600">{{ $invoice->client_name }}</p></li>
@endsection
@section('content')

    <div class="container-fluid">
        @include('partials.flash-message')
        <div class="row">
            <!-- Left column start -->
            <div class="col-md-8">
                <!-- Flying Word card start -->
                <div class="card">
                    <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
                        <h5 class="mr-auto">{{ __('Project') }}: {{ $invoice->project->company_name ?? '' }}</h5>
                        <a href="{{ route('invoices.print', $invoice) }}"
                           class="btn btn-sm btn-success mr-2">{{ __('Print') }}</a>
                        @can('invoice-edit')
                            <a class="btn btn-sm btn-primary"
                               href="{{ route('invoices.edit', $invoice) }}">{{ __('Edit') }}</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{ __('Province/Country') }}</th>
                                        <td>{{ $invoice->country_province ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Section/Plot') }}</th>
                                        <td>{{ $invoice->block_num ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Block No') }}</th>
                                        <td>{{ $invoice->room_number ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('No of Rooms') }}</th>
                                        <td>{{ $invoice->room_number ?? ''}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{ __('Floor No:') }}</th>
                                        <td>{{ $invoice->floor_number ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Gross M²') }}</th>
                                        <td>{{ $invoice->gross_square ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Flat No') }}</th>
                                        <td>{{ $invoice->flat_num ?? ''}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <ul>
                                    <li><strong>{{ __('Price:') }}</strong></li>
                                    <li><strong>{{ __('Cash/Installment:') }}</strong></li>
                                    <li><strong>{{ __('Month:') }}</strong></li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="f-right text-right">
                                    <li>{{ number_format($invoice->price, 2) }} {{ $invoice->currency }}</li>
                                    <li>{{ number_format($invoice->installment, 2) }} {{ $invoice->currency }}</li>
                                    <li>{{ $invoice->month }} {{ __('Month') }}</li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <h6><strong>{{ __('Total') }}</strong></h6>
                            </div>
                            <div class="col-6">
                                <h6 class="f-right text-right">{{ number_format($invoice->price - $invoice->installment , 2) }} {{ $invoice->currency }}</h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <ul>
                                    <li><strong>{{ __('Invoice created:') }}</strong></li>
                                    <li>{{ $invoice->created_at->format('m/d/Y') }}</li>
                                    <br>
                                    <li><strong>{{ __('Created by:') }}</strong></li>
                                    <li><span
                                            class="badge badge-success">{{ $invoice->owner_name ?? $invoice->user->name }}</span>
                                    </li>
                                    <br>
                                    <li><strong>{{ __('Commission Received') }}</strong></li>
                                    <li>
                                        <div class="form-group m-checkbox-inline mb-0 custom-radio-ml"
                                             id="commissionSelect">
                                            <div class="radio radio-primary">
                                                <input id="radioinline1" type="radio" name="radio1"
                                                       value="1"
                                                    {{ $invoice->commission_stat == '1' ? 'checked' : '' }}>
                                                <label class="mb-0" for="radioinline1">{{ __('Yes') }}</span></label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input id="radioinline2" type="radio" name="radio1"
                                                       value="2" {{ $invoice->commission_stat == '2' ? 'checked' : '' }}>
                                                <label class="mb-0" for="radioinline2">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </li>
                                    <br>
                                    <li><strong>{{ __('Status:') }}</strong></li>
                                    <li>
                                        <select name="status" id="status" class="form-control form-control-sm">
                                            <option value="">{{ __('Select status') }}</option>
                                            <option value="1">{{ __('paid') }}</option>
                                            <option value="2">{{ __('Partially paid') }}</option>
                                        </select>
                                    </li>
                                    <br>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="f-right text-right">
                                    <li><strong>{{ __('Commission:') }}</strong></li>
                                    @switch($invoice->currency)
                                        @case('TRY')
                                        <li>{{ number_format($amount) ?? '0.00' }} {{ $invoice->currency }}</li>
                                        @break
                                        @case('EUR')
                                        <li>{{ number_format($amount, 2) ?? '0.00' }} {{ $invoice->currency }}</li>
                                        @break
                                        @case('USD')
                                        <li>{{ number_format($amount, 2) ?? '0.00' }} {{ $invoice->currency }}</li>
                                        @break
                                    @endswitch
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Flying Word card end -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header b-b-primary">
                        <h5 class="text-muted">{{ __('Client:') }} {{ $invoice->client->full_name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <ul>
                                    <li><strong>{{ __('Nationality:') }}</strong></li>
                                    <li>{{ $invoice->nationality ?? '' }}</li>
                                    <br>
                                    <li><strong>{{ __('Passport or ID:') }}</strong></li>
                                    <li>{{ $invoice->passport_id }}</li>
                                    <br>
                                    <li><strong>{{ __('Address:') }}</strong></li>
                                    <li>{{ $invoice->address }}</li>
                                    <br>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            {{ __('Owner:') }}
                            <span class="badge badge-success">{{ $invoice->owner_name }}</span>
                        </div>
                        <div>
                            {{ __('Commission rate:') }}
                            <span class="f-w-600">{{ $invoice->user_commission_rate ?? ''}}</span>
                        </div>
                        <div>
                            {{ __('Commission total:') }}
                            <span class="f-w-600">{{ $invoice->user_commission_total ?? '' }}</span>
                        </div>
                        <br>
                        <div>
                            {{ __('Seller(s):') }}
                            @php $sellRep = collect($invoice->sells_name)->toArray() @endphp
                            @foreach( $sellRep as $name)
                                <span class="badge badge-primary">{{ $name }}</span>
                            @endforeach
                        </div>
                        <div>
                            {{ __('Commission rate:') }}
                            <span class="f-w-600">{{ $invoice->sale_commission_rate ?? ''}}</span>
                        </div>
                        <div>
                            {{ __('Commission total:') }}
                            <span class="f-w-600">{{ $invoice->sale_commission_total ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header b-b-primary">
                        <h5 class="text-muted">
                            {{ __('Company commission:') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <ul>
                                    <li><strong>{{ __('Company:') }}</strong></li>
                                    <li>{{ $invoice->project->company_name ?? $invoice->project->project_name ?? $invoice->project_name }}</li>
                                    <br>
                                    <li><strong>{{ __('Phone:') }}</strong></li>
                                    <li>{{ $invoice->project->phone_1 ?? '' }}</li>
                                    <br>
                                    <li><strong>{{ __('Tax ID:') }}</strong></li>
                                    <li>{!! $invoice->project->tax_number ?? ''!!}</li>
                                    <br>
                                    <li><strong>{{ __('Tax branch:') }}</strong></li>
                                    <li>{{ $invoice->project->text_branch ?? '' }}</li>
                                    <br>
                                    <li><strong>{{ __('Address:') }}</strong></li>
                                    <li>{{ $invoice->project->text_address ?? '' }}</li>
                                    <br>
                                    <li><strong>{{ __('Commission rate:') }}</strong></li>
                                    <li>{{ $invoice->commission_rate ?? '' }} %</li>
                                    <br>
                                    <li><strong>{{ __('Commission total:') }}</strong></li>
                                    <li>{{ $invoice->commission_total ?? '' }} {{ $invoice->currency }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-right mb-4 mt-1 pt-1">
                    <button type="submit" class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#paymentModal">{{ __('Register payment') }}
                    </button>
                </div>
            </div>
        </div>

        @include('invoices._paymentList')

    </div>
    <!-- Page body end -->
    <!-- Edit modal start -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add commission') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <hr>
                <div class="text-center">
                    <h2>{{ __('Amount due') }}</h2>
                    <h3>{{ number_format($amount, 2) ?? '0.00' }} {{ $invoice->currency }}</h3>
                </div>
                <form action="{{ route('payments.store') }}" method="POST" id="paymentForm">
                    @csrf
                    <div class="modal-body p-b-0">
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        <input type="hidden" name="user_id" value="{{ $invoice->user_id }}">
                        <div class="form-group">
                            <label for="">{{ __('Amount in') }} {{ $invoice->currency }}</label>
                            <input type="number" name="amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Payment date') }}</label>
                            <input type="date" name="payment_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="payment_source" id="source" class="form-control">
                                <option value="bank">{{ __('Bank') }}</option>
                                <option value="cash">{{ __('Cash') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="summernote" name="description" id="description"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Save')}} <i class="ti-save-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit modal end -->
@endsection

