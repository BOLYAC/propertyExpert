@extends('layouts.vertical.master')
@section('title', '| Calls')
@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Call') }}</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col mx-auto">
                <div class="card shadow-0 border">
                    <div class="card-body">
                        @if(Session::has('alotech'))
                            <div class="row">
                                <div class="col pr-xl-0 mx-auto">
                                    <div class="row">
                                        <div class="text-center pr-0 call-content">
                                            <div class="total-time">
                                                <h4 class="digits text-danger" id="call-timer">36 : 56</h4>
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
                                                <div class="mt-5">
                                                    <div class="form-group">
                                                        <input type="text" name="title"
                                                               class="form-control form-control-sm"
                                                               placeholder="{{ __('Task Title') }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="datetime-local" name="title"
                                                               class="form-control form-control-sm" required>
                                                    </div>
                                                </div>
                                                <button
                                                    class="btn btn-xs btn-outline-primary pull-right mb-2"><i
                                                        class="fa fa-save"></i> {{ __('Add Task') }}</button>
                                                <div class="form-group">
                                                <textarea class="form-control form-control-sm" name="body_note"
                                                          id="body_note"></textarea>
                                                </div>
                                                <button
                                                    class="btn btn-xs btn-outline-primary pull-right mb-2"><i
                                                        class="fa fa-save"></i> {{ __('Add Note') }}</button>
                                            </div>
                                        </div>
                                    </div>
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
        </div>
    </div>
@endsection
