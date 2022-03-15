@extends('layouts.vertical.master')
@section('title', '| Contact')
@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ __('Contact') }}</li>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            @foreach($users as $user)
                <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
                    <div class="card custom-card">
                        <div class="card-header"><img class="img-fluid"
                                                      src=""
                                                      alt="">
                        </div>
                        <div class="card-profile"><img class="rounded-circle height-90"
                                                       src="{{ asset('storage/' . $user->image_path) }}"
                                                       alt=""></div>
                        <div class="text-center profile-details">
                            <h4>{{ $user->name ?? '' }}</h4>
                            <h6>{{ $user->roles->first()->name ?? '' }}</h6>
                        </div>
                        <ul class="card-social">
                            <li><a href="tel:{{ $user->phone_1 ?? '' }}"><i class="fa fa-phone"></i></a></li>
                            <li><a href="tel:{{ $user->phone_2 ?? '' }}"><i class="fa fa-phone"></i></a></li>
                            <li><a href="mailto:{{ $user->email ?? '' }}"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
