@extends('errors.master'))
@section('title', ' | error-401')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
    <!-- error-401 start-->
    <div class="error-wrapper">
        <div class="container">
            <img class="img-100" src="{{asset('assets/images/other-images/sad.png')}}" alt="">
            <div class="error-heading">
                <h2 class="headline font-warning">401</h2>
            </div>
            <div class="col-md-8 offset-md-2">
                <p class="sub-content">{{ __('The page you are attempting to reach is currently not available. This may be because the page does not exist or has been moved.') }}</p>
            </div>
            <div><a class="btn btn-warning-gradien btn-lg" href="{{route('/')}}">{{ __('') }}</a></div>
        </div>
    </div>
    <!-- error-401 end-->
@endsection

@section('script')
@endsection
