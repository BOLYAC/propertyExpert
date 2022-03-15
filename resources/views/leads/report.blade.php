@extends('layouts.vertical.master')
@section('title', 'Event report')

@section('style_before')
    <!-- Notification.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')

    <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/js/datatables/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
    <script>
        let table = $('#res-config').DataTable({
            @can('can-generate-report')
            dom: 'lfrtBip',
            buttons: [
                {
                    extend: 'excel',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: '',
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: '',
                },
                {
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: '',
                }
            ],
            @endcan
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">{{ __('Reservation list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Reservation report') }}</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <div class="card-header p-2 b-t-primary">
                        <a href="{{ route('deals.view.report', $val) }}"
                           class="btn btn-sm btn-outline-success pull-right">{{ __('Generate report') }}
                            <i class="fa fa-file"></i></a>
                    </div>
                    <div class="card-body">
                        <h1 class="title text-center mb-4">
                            {{ __('RESERVATION REPORT') }}
                            {{ \Carbon\Carbon::parse($val[0])->toDateString() }}
                            {{ __('To') }}
                            {{ \Carbon\Carbon::parse($val[1])->toDateString() }}
                        </h1>
                        <div class="order-history dt-ext table-responsive">
                            <table id="res-config"
                                   class="table task-list-table table-striped table-bordered nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Owner name') }}</th>
                                    <th>{{ __('CUSTOMER NAME') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Project name') }}</th>
                                    <th>{{ __('Province/Country') }}</th>
                                    <th>{{ __('Section/Plot') }}</th>
                                    <th>{{ __('Block No') }}</th>
                                    <th>{{ __('Floor No:') }}</th>
                                    <th>{{ __('No of Rooms') }}</th>
                                    <th>{{ __('Gross M²') }}</th>
                                    <th>{{ __('Flat No') }}</th>
                                    <th>{{ __('Reservation Amount') }}</th>
                                    <th>{{ __('Sale price') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Down payment') }}</th>
                                    <th>{{ __('Payment type') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deals as $key => $deal)
                                    <tr>
                                        <td>{{ $deal->owner_name }}</td>
                                        <td>{{ $deal->lead_name }}</td>
                                        <td>{{ $deal->created_at }}</td>
                                        <td>{{ $deal->project_name }}</td>
                                        <td>{{ $deal->country_province }}</td>
                                        <td>{{ $deal->section_plot }}</td>
                                        <td>{{ $deal->block_num }}</td>
                                        <td>{{ $deal->floor_number }}</td>
                                        <td>{{ $deal->room_number }}</td>
                                        <td>{{ $deal->gross_square }}</td>
                                        <td>{{ $deal->flat_num }}</td>
                                        <td>{{ $deal->reservation_amount }}</td>
                                        <td>{{ $deal->sale_price }}</td>
                                        <td>{{ $deal->excerpt }}</td>
                                        <td>
                                            {{ $deal->payment_type === 1 ? 'Cash' : 'Installment' }}
                                        </td>
                                        <td>{{ $deal->down_payment }}</td>
                                        <td>{{ $deal->payment_discount }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="col-lg-12 col-xl-6">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{__('Total records in this page:')}}</th>
                                        <td>{{ $deals->count() }} {{ __('Record(s)') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Report Generated by:') }}</th>
                                        <td>{{ auth()->user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Generated on:') }}</th>
                                        <td>{{ \Carbon\Carbon::now()->format('Y-m-d g:i a') }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
