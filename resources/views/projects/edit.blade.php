@extends('layouts.vertical.master')
@section('title', '| Project edit')
@section('style_before')
    <!-- Summernote.css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
    <!-- Datatables.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-extension.css') }}">
@endsection

@section('script')
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/notify/notify-script.js') }}"></script>
    <script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(function () {
            // Init Table Apartments
            let table = $('#res-config').DataTable();
            // Edit apartment
            table.on('click', '.edit', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#unit_type').val(data[0]);
                $('#flat_type').val(data[1]);
                $('#floor').val(data[2]);
                $('#gross_sqm').val(data[3]);
                $('#net_sqm').val(data[4]);
                let id = $(this).data('id');
                $('#property_id').val(id)
                $('#editForm').attr('action', '/properties/' + id);
                $('#editModal').modal('show');
            })
            // Delete apartment
            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                let id = $(this).data('id');
                $('#deleteForm').attr('action', '/properties/' + id);
                $('#deleteModal').modal('show');
            })
        })
    </script>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('Project list') }} </a></li>
    <li class="breadcrumb-item">{{ __('edit project') }}: {{ $project->project_name }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6">
                <!-- Zero config.table start -->
                @include('partials.flash-message')
                <div class="card">
                    <form action="{{ route('projects.update', $project) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body b-t-primary">
                            <div class="row">
                                <div class="form-group input-group-sm col-12">
                                    <label for="company_name">{{ __('Company name') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="company_name"
                                           id="company_name"
                                           value="{{ old('company_name', $project->company_name) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="phone_1">{{ __('Phone') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="phone_1" id="phone_1"
                                           value="{{ old('phone_1', $project->phone_1) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="phone_2">{{ __('Phone 2') }}</label>
                                    <input class="form-control sm" type="text" name="phone_2" id="phone_2"
                                           value="{{ old('phone_2', $project->phone_2) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col-sm">
                                    <label for="tax_number">{{ __('Tax ID') }}</label>
                                    <input class="form-control form-control-sm" type="text" name="tax_number"
                                           id="tax_number"
                                           value="{{ old('tax_number', $project->tax_number) }}">
                                </div>
                                <div class="form-group input-group-sm col-sm">
                                    <label for="tax_branch">{{ __('Tax branch') }}</label>
                                    <input class="form-control sm" type="text" name="tax_branch" id="tax_branch"
                                           value="{{ old('tax_branch', $project->tax_branch) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="commission_rate">{{ __('Commission rate') }}</label>
                                    <input class="form-control sm" type="text" name="commission_rate"
                                           id="commission_rate"
                                           value="{{ old('commission_rate', $project->commission_rate) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="project_name">{{ __('Project name') }}</label>
                                    <input class="form-control sm" type="text" name="project_name" id="project_name"
                                           value="{{ old('project_name', $project->project_name) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="type">{{ __('Type') }}</label>
                                    <select name="type" id="type" class="form-control form-control-sm">
                                        <option
                                            value="1" {{ $project->type == 1 ? 'selected': '' }}>{{ __('Apartment') }}</option>
                                        <option
                                            value="2" {{ $project->type == 2 ? 'selected': '' }}>{{ __('Home Office') }}</option>
                                        <option
                                            value="3" {{ $project->type == 3 ? 'selected': '' }}>{{ __('Office') }}</option>
                                        <option
                                            value="4" {{ $project->type == 4 ? 'selected': '' }}>{{ __('Residential') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="address">{{ __('Address') }}</label>
                                    <textarea class="summernote" type="text" name="address"
                                              id="note"> {{ old('address', $project->address) }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="phone">{{ __('Website') }}</label>
                                    <input class="form-control sm" type="text" name="link" id="link"
                                           value="{{ old('link', $project->link) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col-sm">
                                    <label for="min_price">{{ __('Min Price') }}</label>
                                    <input class="form-control sm" type="text" name="min_price" id="min_price"
                                           value="{{ old('min_price', $project->min_price) }}">
                                </div>
                                <div class="form-group input-group-sm col-sm">
                                    <label for="max_price">{{ __('Max price') }}</label>
                                    <input class="form-control sm" type="text" name="max_price" id="max_price"
                                           value="{{ old('max_price', $project->max_price) }}">
                                </div>
                                <div class="form-group input-group-sm col-sm">
                                    <label for="min_size">{{ __('Min size') }}</label>
                                    <input class="form-control sm" type="text" name="min_size" id="min_size"
                                           value="{{ old('min_size', $project->min_size) }}">
                                </div>
                                <div class="form-group input-group-sm col-sm">
                                    <label for="max_size">{{ __('Max size') }}</label>
                                    <input class="form-control sm" type="text" name="max_size" id="max_size"
                                           value="{{ old('max_size', $project->max_size) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Map') }}</label>
                                    <input class="form-control sm" type="text" name="map" id="map"
                                           value="{{ old('map', $project->map) }}">
                                </div>
                                <div class="form-group input-group-sm col">
                                    <label for="email">{{ __('Drive Link') }}</label>
                                    <input class="form-control sm" type="text" name="drive" id="drive"
                                           value="{{ old('drive', $project->drive) }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary">
                                {{ __('save') }}
                                <i class="icon-save"></i></button>
                            <a href="{{ route('projects.index') }}"
                               class="btn btn-sm btn-warning">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header p-2">
                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                data-original-title="new apartment"
                                data-target="#newApartment">{{ __('New apartment') }}
                        </button>
                    </div>
                    <div class="card-body b-t-primary">
                        <div class="dt-ext table-responsive">
                            <table id="res-config" class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th>{{ __('Unit Type') }}</th>
                                    <th>{{ __('Flat Type') }}</th>
                                    <th>{{ __('Floor') }}</th>
                                    <th>{{ __('Gross SQM') }}</th>
                                    <th>{{ __('Net SQM') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($project->properties as $property)
                                    <tr>
                                        <td>{{ $property->unit_type ?? '' }}</td>
                                        <td>{{ $property->flat_type ?? '' }}</td>
                                        <td>{{ $property->floor ?? '' }}</td>
                                        <td>{{ $property->gross_sqm ?? '' }}</td>
                                        <td>{{ $property->net_sqm ?? '' }}</td>
                                        <td class="action-icon">
                                            <a href="javascript:void(0)"
                                               class="m-r-15 text-muted f-18 edit" data-id="{{ $property->id }}">
                                               <i class="icofont icofont-eye-alt"></i>
                                            </a>
                                            <a href="#!" class="m-r-15 text-muted f-18 delete" data-id="{{ $property->id }}">
                                                <i class="icofont icofont-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Create apartment -->
    <div class="modal fade" id="newApartment" tabindex="-1" role="dialog" aria-labelledby="new_apartment"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new_apartment">{{ __('New apartment') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('properties.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="form-group">
                            <label for="">{{ __('Unit Type') }}</label>
                            <input type="text" name="unit_type" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Flat Type') }}</label>
                            <input type="text" name="flat_type" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Floor') }}</label>
                            <input type="text" name="floor" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Gross SQM') }}</label>
                            <input type="text" name="gross_sqm" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Net SQM') }}</label>
                            <input type="text" name="net_sqm" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-secondary" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End create apartment -->
    <!-- Edit modal start -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit apartment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="property_id" id="property_id">
                        <div class="form-group">
                            <label for="">{{ __('Unit Type') }}</label>
                            <input type="text" name="unit_type" id="unit_type" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Flat Type') }}</label>
                            <input type="text" name="flat_type" id="flat_type" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Floor') }}</label>
                            <input type="text" name="floor" id="floor" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Gross SQM') }}</label>
                            <input type="text" name="gross_sqm" id="gross_sqm" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Net SQM') }}</label>
                            <input type="text" name="net_sqm" id="net_sqm" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-secondary" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit modal end -->
    <!-- Delete modal start -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete apartment')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-b-0">
                        <p>{{ __('Are sur you want to delete this apartment?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Delete') }} <i class="icon-trash"></i>
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete modal end -->
@endsection
