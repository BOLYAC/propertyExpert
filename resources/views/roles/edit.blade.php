@extends('layouts.vertical.master')
@section('title', 'Edit role')
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Role list') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit role') }}</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('roles.update', $role) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="form-group input-group-sm">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control sm" type="text" name="name" id="name"
                                       value="{{ old('name', $role->name) }}">
                            </div>
                            <hr>
                            <div>
                                <label>
                                    <input type="checkbox" id="checkAll"> {{ __('Check All') }}
                                </label>
                            </div>
                            <hr/>
                            <div class="form-group input-group-sm">
                                <div class="row">
                                    @foreach($permission->split($permission->count()/4) as $row)
                                        <div class="col-4" data-aos="fade-right" data-aos-duration="2000">
                                            @foreach($row as $value)
                                                <label>
                                                    <input type="checkbox" name="permission[]"
                                                           value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? ' checked' : '' }}>
                                                    {{ $value->name }}
                                                </label>
                                                <br/>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                        </div>
                    </form>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
            <!-- Zero config.table end -->
        </div>
    </div>
    </div>
    <!-- Page body end -->
    </div>

@endsection

@push('scripts')
    <script>
        ///////// Deselect all
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endpush
