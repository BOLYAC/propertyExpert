@extends('layouts.vertical.master')
@section('title', '| Email compose')

@section('style_before')
@endsection

@section('script')
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script>
        $('.btn-mail').click(function (e) {
            e.preventDefault()
            $('.theme-form').submit()
        })
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Compose email') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="email-wrap">
                    <div class="row">
                        <div class="col-xl-8 col-md-12 box-col-12 mx-auto">
                            <div class="email-right-aside">
                                <div class="card email-body radius-left">
                                    <div class="pl-0">
                                        <div class="email-compose">
                                            <div class="email-top compose-border">
                                                <div class="row">
                                                    <div class="col-sm-8 xl-50">
                                                        <h4 class="mb-0">{{ __('New Email') }}</h4>
                                                    </div>
                                                    <div class="col-sm-4 btn-middle xl-50">
                                                        <button
                                                            class="btn btn-primary btn-block btn-mail text-center mb-0 mt-0"
                                                            type="button"><i class="fa fa-paper-plane mr-2"></i>
                                                            {{ __('SEND') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="email-wrapper">
                                                <form class="theme-form" method="post"
                                                      action="{{ route('clients.send.email') }}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="col-form-label pt-0"
                                                               for="exampleInputEmail1">{{ __('To') }}</label>
                                                        <input class="form-control" id="exampleInputEmail1"
                                                               name="email"
                                                               type="email" value="{{ $email }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            for="exampleInputPassword1">{{ __('Subject') }}</label>
                                                        <input class="form-control"
                                                               id="exampleInputPassword1"
                                                               name="subject"
                                                               type="text">
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label class="text-muted">{{ __('Message') }}</label>
                                                        <textarea id="text-box" name="text-box" cols="10"
                                                                  rows="2">                                                            </textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
