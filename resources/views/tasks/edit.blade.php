@extends('layouts.app')

@push('style')
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}"/>
@endpush

@section('content')

    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page header start -->
            <div class="page-header">
                <div class="page-header-title">
                    <h4>Tasks {{ $task->title }}</h4>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">List</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-8 mx-auto">
                        <!-- Zero config.table start -->
                        @include('partials.flash-message')
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-block">
                                <form action="{{ route('tasks.update', $task) }}" method="POST" id="editForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-b-0">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="title">
                                                    Title
                                                </label>
                                                <input class="form-control" type="text" name="title" id="title"
                                                       value="{{ old('name', $task->name ?? '') }}"
                                                       placeholder="Task title">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="date">Date</label>
                                                <input name="date"
                                                       id="date"
                                                       class="form-control"
                                                       value="{{ old('date', optional($task->date)->format('Y-m-d')) }}"
                                                       type="date"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control js-client-all" name="client_id" id="client_id">
                                                <option selected="selected">Search for the client</option>
                                                <option value="{{ $task->client_id }}"
                                                        selected>{{ $task->client->full_name }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="body" id="body" cols="10"
                                                      rows="3">{{ old('body', $task->body ?? '') }}</textarea>
                                        </div>
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="archive" id="archive" name="type"
                                                       id="type" {{ $task->archive === 1 ? 'checked' : '' }}>
                                                <span class="cr"><i
                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">{{ __('Archive') }}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save <i class="ti-save-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                                        </button>
                                    </div>
                                </form>
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
    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('assets/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('.js-client-all').each(function () {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                    ajax: {
                        url: "{{ route('event.client.filter') }}",
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.full_name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
        });
    </script>
@endpush
