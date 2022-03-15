@extends('layouts.app')
@push('style')
<!-- DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@endpush
@section('content')

<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Clients List</h4>
      </div>
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
              <i class="icofont icofont-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Clients</a>
          </li>
          <li class="breadcrumb-item"><a href="#!">List</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page header end -->
    <!-- Page body start -->
    <div class="page-body" id="app">
      <div class="row">
        <div class="col-sm-12">
          <!-- Zero config.table start -->
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-12 mt-4">
                  <header-clients></header-clients>
                </div>
              </div>

            </div>
            <div class="card-block">
              <list-clients></list-clients>
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
<script src="{{  asset('js/app.js') }}"></script>
@endpush