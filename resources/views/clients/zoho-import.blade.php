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
            <div class="col-8 mx-auto">
                <div class="card">
                    <div class="card-header b-b-primary b-t-primary">
                        <h5>{{ __('File Upload') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('zohoImport') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="user_id">{{ __('Agent') }}</label>
                                <select class="form-control" name="user_id" id="user_id">
                                    <option value="">-- {{ __('Select agent') }} --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="source_id">{{ __('Source') }}</label>
                                <select class="form-control" name="source_id" id="source_id">
                                    <option value="" selected> -- {{ __('Select source') }} --</option>
                                    @foreach($sources as $source)
                                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Upload File') }}</label>
                                <input name="file" type="file" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"><i
                                    class="icon-upload"></i>
                                {{ __('Import') }}
                            </button>
                        </form>
                    </div>
                </div>
                <!-- File upload card end -->
                <!-- Show Errors -->
                @if( session()->has('failures'))
                    <div class="card col-8 mx-auto">
                        <div class="card-header">
                            <h5>{{ __('Errors') }}</h5>
                        </div>
                        <div class="card-block">
                            <table class="table table-danger">
                                <tr>
                                    <th>{{ __('Row') }}</th>
                                    <th>{{__('Attribute')}}</th>
                                    <th>{{ __('Errors') }}</th>
                                    <th>{{__('Value')}}</th>
                                </tr>
                                @foreach(session()->get('failures') as $validation)
                                    <tr>
                                        <td>{{ $validation->row() }}</td>
                                        <td>{{ $validation->attribute() }}</td>
                                        <td>
                                            <ul>
                                                @foreach($validation->errors() as $e)
                                                    <li>{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $validation->values()[$validation->attribute()] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
            @endif
            <!-- End show errors -->
            </div>
        </div>
        <!-- Page body end -->
    </div>

@endsection
