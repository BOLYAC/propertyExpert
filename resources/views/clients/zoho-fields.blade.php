@extends('layouts.vertical.master')
@section('title', 'Import zoho leads')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Leads lists') }}</a></li>
    <li class="breadcrumb-item">{{ __('Import zoho leads') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- File upload card start -->
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card">
                    <div class="card-header b-b-primary b-t-primary">
                        <h5>{{ __('File Upload') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('zohoImport') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                @foreach($headings[0][0] as $k => $value)
                                    <div class="col-2" data-aos="fade-right" data-aos-duration="2000">
                                        <label>
                                            <input type="checkbox" name="fields[]"
                                                   value="{{ $value }}" class="field">
                                            {{ $value }}
                                        </label>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary btn-block"><i
                                        class="icon-upload"></i>
                                    {{ __('Import') }}
                                </button>
                        </form>
                    </div>
                </div>
                <!-- File upload card end -->
                <!-- End show errors -->
            </div>
        </div>
        <!-- Page body end -->
    </div>

@endsection
