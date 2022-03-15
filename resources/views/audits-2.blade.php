@extends('layouts.app')
@section('content')
<!-- Main-body start -->
<div class="main-body">
  <div class="page-wrapper">
    <!-- Page header start -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Role List</h4>
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
          <li class="breadcrumb-item"><a href="#!">Audits</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Page header end -->
    <!-- Page body start -->
    <div class="page-body">
      <div class="row">
        <div class="col-12 mx-auto">
          <!-- Zero config.table start -->
          @include('partials.flash-message')
          <div class="card">
            <div class="card-header">
            </div>
            <div class="card-block">
              <ul>
                @forelse ($audits as $audit)
                <li>
                  @lang('article.updated.metadata', $audit->getMetadata())

                  @foreach ($audit->getModified() as $attribute => $modified)
                  <ul>
                    <li>@lang('article.'.$audit->event.'.modified.'.$attribute, $modified)</li>
                  </ul>
                  @endforeach
                </li>
                @empty
                <p>@lang('article.unavailable_audits')</p>
                @endforelse
              </ul>
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