@extends('layouts.vertical.master')
@section('title', 'Show project')
@section('style_before')

@endsection

@section('script')
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/google-maps/gmaps.js') }}"></script>
    <script>
        $(document).ready(function () {
            /*Basic map
            var basic;
            basic = new GMaps({
                el: '#basic-map',
                lat: 21.217319,
                lng: 72.866472,
                scrollwheel: false
            });*/

            /*markers map*/
            var map;
            map = new GMaps({
                el: '#markers-map',
                lat: '{{ $project['property_meta']['houzez_geolocation_lat'][0] ?? '' }}',
                lng: '{{ $project['property_meta']['houzez_geolocation_long'][0] ?? '' }}',
                scrollwheel: false
            });

            map.addMarker({
                lat: '{{ $project['property_meta']['houzez_geolocation_lat'][0] ?? '' }}',
                lng: '{{ $project['property_meta']['houzez_geolocation_long'][0] ?? '' }}',
                title: 'Marker with InfoWindow',
                infoWindow: {
                    content: ''
                }
            });
        });
    </script>

@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('Project list') }}</a></li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- tab header start -->
                <div class="tab-header">
                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal"
                               role="tab">{{__('Project Info')}}</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                </div>
                <!-- tab header end -->
                <!-- tab content start -->
                <div class="tab-content">
                    <!-- tab panel personal start -->
                    <div class="tab-pane active" id="personal" role="tabpanel">
                        <!-- personal card start -->
                        <div class="card blog-page">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="blog-single col-8">
                                            <img src="{{ $image['source_url'] ?? ''}}" alt="image-blog"
                                                 class="img-fluid w-100">
                                        </div>
                                        <div class="col-4">
                                            <!-- Markers map start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>{{ __('Location') }}</h5>
                                                </div>
                                                <div class="card-block">
                                                    <div id="markers-map" class="set-map"></div>
                                                </div>
                                            </div>
                                            <!-- Markers map end -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($images as $key => $img)
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <a href="{{ $img }}" data-lightbox="1"
                                                           data-title="My caption 1">
                                                            <img src="{{ $img }}" alt=""
                                                                 class="img-fluid img-thumbnail">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <table class="table m-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">ID</th>
                                                            <td>{{ $project['id'] ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Name') }}</th>
                                                            <td>{{ $project['title']['rendered'] ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Status') }}</th>
                                                            <td>{{ $project['status'] ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{__('Type')}}</th>
                                                            <td>{{ $project['type'] ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{__('Link')}}</th>
                                                            <td><a href="{{ $project['link'] ?? '' }}"
                                                                   target="_blank">{{ $project['link'] ?? '' }}</a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end of table col-lg-6 -->
                                                <div class="col-lg-12 col-xl-6">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">{{ __('Location') }}</th>
                                                            <td><a href="#!"></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Min Price') }}</th>
                                                            <td>{{ number_format($project['property_meta']['fave_property_price'][0] ?? '', 0)  }}
                                                                {{ $project['property_meta']['fave_currency'][0] ?? '' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Max price') }}</th>
                                                            <td>
                                                                {{ number_format($project['property_meta']['fave_property_sec_price'][0] ?? '', 0) }}
                                                                {{ $project['property_meta']['fave_currency'][0] ?? '' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Size') }}</th>
                                                            <td>{{ $project['property_meta']['fave_property_size'][0] ?? ''}}
                                                                m²
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- end of table col-lg-6 -->
                                            </div>
                                            <!-- end of row -->
                                        </div>
                                        <!-- end of general info -->
                                    </div>
                                    <!-- end of col-lg-12 -->
                                </div>
                                <!-- end of row -->
                            </div>
                            <!-- end of view-info -->
                        </div>
                        <!-- end of card-block -->
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header b-t-primary b-b-primary">
                                    <h5 class="text-muted">{{ __('Description') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="view-desc">
                                        <p>{!! $project['excerpt']['rendered'] ?? '' !!}</p>
                                    </div>
                                    <div class="view-desc">
                                        <p>{!! $project['content']['rendered'] ?? '' !!}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- personal card end-->
                </div>
                <!-- tab pane personal end -->
            </div>
            <!-- tab content end -->
        </div>
    </div>

@endsection
