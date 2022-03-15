<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <title>Hashim Group CRM @yield('title')</title>
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
    <div class="customizer-contain">
        <div class="customizer-body">
            @if(Session::has('alotech'))
                <div class="text-center pr-0 call-content">
                    <div>
                        <h6 class="text-center" id="leadNameForDeal"></h6>
                    </div>
                    <div class="total-time">
                        <h5 class="digits text-danger" id="call-timer">00 : 00</h5>
                    </div>
                    <div class="container-calls">
                        <div id="output"></div>
                        <div class="row justify-content-center">
                            <div class="digit" id="one">1</div>
                            <div class="digit" id="two">2</div>
                            <div class="digit" id="three">3</div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="digit" id="four">4</div>
                            <div class="digit" id="five">5</div>
                            <div class="digit" id="six">6</div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="digit" id="seven">7</div>
                            <div class="digit" id="eight">8</div>
                            <div class="digit" id="nine">9</div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="digit">*</div>
                            <div class="digit" id="zero">0</div>
                            <div class="digit">#</div>
                        </div>
                        <div class="botrow">
                            <div id="click2call">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div id="endCall">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                            </div>
                            <div id="removeNumber">
                                <i class="fa fa-long-arrow-left dig"
                                   aria-hidden="true"></i>
                            </div>
                        </div>
                        @livewire('radial-tasks')
                        @livewire('radial-notes')
                    </div>
                </div>
            @else
                <div class="m-2 p-2">
                    <h6>{{  __('AloTech connection') }}</h6>
                    <form action="{{ route('alotech.login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="login">{{ __('Email') }}</label>
                            <input type="email" id="login" name="email"
                                   class="form-control form-control-sm">
                        </div>
                        <button class="btn btn-sm btn-primary"
                                type="submit">{{ __('Login') }}</button>
                    </form>
                </div>
            @endif
        </div>
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
