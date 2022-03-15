@extends('layouts.vertical.master')
@section('title', 'Dashboard')

@section('style_before')

@endsection

@section('script')

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item">Simple Dashboard</li>
@endsection

@section('breadcrumb-title')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 xl-100 box-col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="project-overview">
                            <div class="row">
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-primary">{{ $allClients }}</h2>
                                    <p class="mb-0">{{ __('Total leads') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-secondary">{{ $olderTask }}</h2>
                                    <p class="mb-0">{{ __('Past tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-success">{{ $completedTasks }}</h2>
                                    <p class="mb-0">{{ __('Completed tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-info">{{ $todayTasks }}</h2>
                                    <p class="mb-0">{{ __('Today tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-danger">{{ $tomorrowTasks }}</h2>
                                    <p class="mb-0">{{ __('Tomorrow tasks') }}</p>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <h2 class="f-w-600 counter font-warning">{{ $events }}</h2>
                                    <p class="mb-0"><a
                                            href="{{ route('events.index', 'today-event') }}">{{ __('Today Appointment(s)') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row col-8 col-auto">
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('clients.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="anchor"></i> Leads</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('tasks.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="check-square"></i> Tasks</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('events.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="calendar"></i> Calender</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 xl-40 box-col-5">
                <a href="{{ route('leads.index') }}">
                    <div class="card card-with-border bg-primary o-hidden">
                        <div class="birthday-bg"></div>
                        <div class="card-body">
                            <h4><i data-feather="tag"></i> Deals</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection


