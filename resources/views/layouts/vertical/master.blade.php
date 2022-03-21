<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <title>Property Experts Tr @yield('title')</title>
    @livewireStyles
    @include('layouts.vertical.css')
    @yield('style')
</head>
<body class="light-only" main-theme-layout="ltr">
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader"></div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
@include('layouts.compact.header')
<!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
        <nav-menus></nav-menus>
    @include('layouts.compact.sidebar')
    <!-- Page Sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="f-16 fa fa-home"></i></a>
                                </li>
                                @yield('breadcrumb-items')
                            </ol>
                            @yield('breadcrumb-title')
                        </div>
                        @yield('bookmarks-start')
                    </div>
                </div>
            </div>
        @yield('content')
        <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        @include('layouts.compact.footer')
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Result found:') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-b-0">
                <div class="card card-with-border connection">
                    <div class="card-body p-0">
                        <ul class="search-content-result">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@livewireScripts
@include('layouts.vertical.script')
@stack('scripts')
</body>
</html>
