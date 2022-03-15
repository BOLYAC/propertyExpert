<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <title>Hashim Group CRM | {{ __('Print') }}</title>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/print.js') }}"></script>
    @include('layouts.vertical.css')
</head>
<body class="light-only" main-theme-layout="ltr">
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader"></div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper horizontal-wrapper" id="pageWrapper">
    <div class="page-body-wrapper horizontal-menu">
        <nav-menus></nav-menus>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid mb-5">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice">
                                    <div>
                                        <div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="media">
                                                        <div class="media-left"><img class="media-object img-60"
                                                                                     src="{{ asset('assets/images/HASHIM_PROPERTY.png') }}"
                                                                                     alt=""></div>
                                                        <div class="media-body m-l-20">

                                                        </div>
                                                    </div>
                                                    <!-- End Info-->
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="text-md-right">
                                                        <h3>{{ __('Invoice #') }}<span
                                                                class="digits counter">{{ $invoice->id }}</span></h3>
                                                        <p>{{ __('Date:') }} <span
                                                                class="digits"> {{ $invoice->created_at->format('Y-m-d') }}</span>
                                                        </p>
                                                    </div>
                                                    <!-- End Title-->
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- End InvoiceTop-->
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="media">
                                                    <div class="media-left"><img
                                                            class="media-object rounded-circle img-60"
                                                            src="{{ asset('storage/' . $invoice->user->image_path)  }}"
                                                            alt=""></div>
                                                    <div class="media-body m-l-20 row">
                                                        <div class="col-4">
                                                            <h5 class="media-heading">{{ __('Sales owner') }}</h5>
                                                            <p><strong>{{ $invoice->user->name  }}</strong></p>
                                                        </div>
                                                        <div class="col-4">
                                                            <h5 class="media-heading">{{ __('Sales type') }}</h5>
                                                            <p>
                                                                <strong>{{ $invoice->payments()->first()->payment_source ?? 'Cash'  }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-4">
                                                            <h5 class="media-heading">{{ __('Sales stage') }}</h5>
                                                            <p><strong>{{ __('Invoice will be issued')  }}</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="text-md-right" id="project">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- End Invoice Mid-->
                                        <div>
                                            <div class="table-responsive invoice-table" id="table">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                    <tr>
                                                        <td class="item">
                                                            <h6 class="p-2 mb-0">{{ __('Source') }}</h6>
                                                        </td>
                                                        <td class="Hours">
                                                            <h6 class="p-2 mb-0">{{ __('Customer Name') }}</h6>
                                                        </td>
                                                        <td class="Rate">
                                                            <h6 class="p-2 mb-0">{{ __('Sales details') }}</h6>
                                                        </td>
                                                        <td class="subtotal">
                                                            <h6 class="p-2 mb-0">{{ __('Sales Price') }}</h6>
                                                        </td>
                                                        <td class="subtotal">
                                                            <h6 class="p-2 mb-0">{{ __('Commission Rate') }}</h6>
                                                        </td>
                                                        <td class="subtotal">
                                                            <h6 class="p-2 mb-0">{{ __('Commission') }}</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p><strong>{{ $invoice->client->source->name }}</strong></p>
                                                        </td>
                                                        <td>
                                                            <p><strong>{{ $invoice->client->full_name }}</strong></p>
                                                        </td>
                                                        <td>
                                                            <p>
                                                                <strong>{{ __('Block N°:') }}</strong>{{ $invoice->block_num ?? '' }}
                                                                <strong>{{ __('No of Rooms:') }}</strong>{{ $invoice->room_number ?? ''}}
                                                                <strong>{{ __('Floor No:') }}</strong>{{ $invoice->floor_number ?? ''}}
                                                                <strong>{{ __('Flat No') }}</strong>{{ $invoice->flat_num ?? ''}}
                                                                <strong>{{ __('Gross M²') }}</strong>{{ $invoice->gross_square ?? '' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p>
                                                                @switch($invoice->currency)
                                                                    @case('TRY')
                                                                    <strong>{{ number_format($invoice->price) ?? '0.00' }} {{ $invoice->currency }}</strong>
                                                                    @break
                                                                    @case('EUR')
                                                                    <strong>{{ number_format($invoice->price, 2) ?? '0.00' }} {{ $invoice->currency }}</strong>
                                                                    @break
                                                                    @case('USD')
                                                                    <strong>{{ number_format($invoice->price, 2) ?? '0.00' }} {{ $invoice->currency }}</strong>
                                                                    @break
                                                                @endswitch
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p><strong>{{ $invoice->commission_rate }} %</strong></p>
                                                        </td>
                                                        <td>
                                                            <p>
                                                                @switch($invoice->currency)
                                                                    @case('TRY')
                                                                    <strong>{{ number_format($invoice->commission_total) ?? '0.00' }} {{ $invoice->currency }}</strong>
                                                                    @break
                                                                    @case('EUR')
                                                                    <strong>{{ number_format($invoice->commission_total, 2) ?? '0.00' }} {{ $invoice->currency }}</strong>
                                                                    @break
                                                                    @case('USD')
                                                                    <strong>{{ number_format($invoice->commission_total, 2) ?? '0.00' }} {{ $invoice->currency }}</strong>
                                                                    @break
                                                                @endswitch
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="Rate">
                                                            <h6 class="mb-0 p-2">{{ __('Subtotal:') }}</h6>
                                                        </td>
                                                        <td class="payment digits">
                                                            <h6 class="mb-0 p-2">
                                                                @switch($invoice->currency)
                                                                    @case('TRY')
                                                                    {{ number_format($invoice->commission_total) ?? '0.00' }} {{ $invoice->currency }}
                                                                    @break
                                                                    @case('EUR')
                                                                    {{ number_format($invoice->commission_total, 2) ?? '0.00' }} {{ $invoice->currency }}
                                                                    @break
                                                                    @case('USD')
                                                                    {{ number_format($invoice->commission_total, 2) ?? '0.00' }} {{ $invoice->currency }}
                                                                    @break
                                                                @endswitch
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="Rate">
                                                            <h6 class="mb-0 p-2">{{ __('Tax:') }}</h6>
                                                        </td>
                                                        <td class="payment digits">
                                                            <h6 class="mb-0 p-2"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="Rate">
                                                            <h6 class="mb-0 p-2">{{ __('Total:') }}</h6>
                                                        </td>
                                                        <td class="payment digits">
                                                            <h6 class="mb-0 p-2">
                                                                @switch($invoice->currency)
                                                                    @case('TRY')
                                                                    {{ number_format($invoice->commission_total) ?? '0.00' }} {{ $invoice->currency }}
                                                                    @break
                                                                    @case('EUR')
                                                                    {{ number_format($invoice->commission_total, 2) ?? '0.00' }} {{ $invoice->currency }}
                                                                    @break
                                                                    @case('USD')
                                                                    {{ number_format($invoice->commission_total, 2) ?? '0.00' }} {{ $invoice->currency }}
                                                                    @break
                                                                @endswitch
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End Table-->
                                            <div class="row mt-4">
                                                <div class="col-md-8">
                                                    <div>
                                                        <h6>{{ __('Company Details') }}</h6>
                                                        <p class="legal">
                                                            <strong>{{ __('Company Name:') }}</strong><br>{{$invoice->project->company_name ?? ''}}
                                                            <br><strong>{{ __('Company Address:') }}</strong><br>{{$invoice->project->company_name ?? ''}}
                                                            <br><strong>{{ __('Tax branch:') }}</strong><br>{{$invoice->project->tax_branch ?? ''}}
                                                            <br><strong>{{ __('Tax ID:') }}</strong><br>{{$invoice->project->tax_number ?? ''}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End InvoiceBot-->
                                    </div>
                                    <div class="col-sm-12 text-center mt-4 row">
                                        <div class="col-6 mx-auto">
                                            <p class="legal">
                                                {{ __('General Manager') }}<br><b>FERHAT POSMA</b>
                                            </p>
                                        </div>
                                        <div class="col-6 mx-auto">
                                            <p class="legal">
                                                {{ __('Sales Manager') }}<br><b>REHA NURI TALU</b>
                                            </p>
                                        </div>
                                        <div class="col-12 mx-auto">
                                            <p class="legal">
                                                {{ __('Chairman') }}<br><b>HAŞİM SÜNGÜ</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer mt-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mx-auto text-center m-0 p-0">
                            <p>
                                {{ auth()->user()->department->description ?? 'HASHIM GAYRİMENKUL YATIRIMLARI SAN.VE TİC.A.Ş.'}}</p>
                        </div>
                        <div class="col-12 mx-auto text-center m-0 p-0">
                            <p>
                                {{ auth()->user()->department->address ?? 'Ömer Avni, İnönü Cd. No:48/15, 34427 Beyoğlu/İstanbul,'}}
                                {{ auth()->user()->department->phone ?? '+90 212 292 92 92' }}
                                {{ auth()->user()->department->email ?? 'info@hashimproperty.com' }}
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

@include('layouts.vertical.script')
</body>
</html>
