@extends('layouts.vertical.master')
@section('title', 'Settings')
@section('breadcrumb-items')>
<li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body b-t-primary">
                        <div class="row icon-lists">
                            <div class="col-lg-4 col-sm-6">
                                <a href="{{ route('backupDatabes') }}">
                                    <i class="fa fa-database"></i>
                                    {{ __('Database backup') }}
                                </a>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <a href="{{ route('backupFiles') }}">
                                    <i class="fa fa-file-archive-o"></i>
                                    {{ __('Files backup') }}
                                </a>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <a href="{{ route('cacheClear') }}">
                                    <i class="fa fa-recycle"></i>
                                    {{ __('Clear cache') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
@endsection
