@extends('layouts/contentLayoutMaster')

@section('title', $agent->name)
@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style>

        .plan_form {
            border-color: #1976d2;
            background-color: #1976d2;
            color: #fff;
            min-width: 44px;
            width: auto;
        }
    </style>
@endsection
@section('content')
    <style>
        #map {

            height: 400px;
        }

        .map-form {
            border-color: #1976d2;
            background-color: #1976d2;
            color: #fff;
            min-width: 44px;
            width: auto;
        }
    </style>
    <section id="basic-tabs-components">
        <div class="row match-height">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$agent->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Attributes</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>
                                                <a href="#"> <span class="badge rounded-pill badge-light-danger me-50"  id="User">{{$agent->name}}</span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>email</td>
                                            <td>
                                                <a href="#"> <span class="badge rounded-pill badge-light-danger me-50"  id="User">{{$agent->email}}</span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>phone</td>
                                            <td>
                                                <a href="#"> <span class="badge rounded-pill badge-light-danger me-50"  id="User">{{$agent->phone}}</span></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="col-md-12 mt-2">
                                <div id="preloader" class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{asset('Plugins/highchart/code/highcharts.js')}}"></script>
    <script src="{{asset('Plugins/highchart/code/modules/exporting.js')}}"></script>
    <script src="{{asset('Plugins/highchart/code/themes/grid.js')}}"></script>
    <script type="text/javascript"
            src="{your google map key}">
    </script>
@endsection

@section('page-script')
    <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>
    <script>
        let map;
        let infoWindow;
        var area;
        var bounds;

        function initMap(poly) {
            myCenter = poly[1];
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: myCenter,
                mapTypeId: "terrain",
            });
            const bermudaTriangle = new google.maps.Polygon({
                paths: poly,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
            });

            bermudaTriangle.setMap(map);
            bermudaTriangle.addListener("click", showArrays);
            infoWindow = new google.maps.InfoWindow();

        }

        function showArrays(event) {
            const polygon = this;
            const vertices = polygon.getPath();
            let contentString =
                "<b>Bermuda Triangle polygon</b><br>" +
                "Clicked location: <br>" +
                event.latLng.lat() +
                "," +
                event.latLng.lng() +
                "<br>";
            for (let i = 0; i < vertices.getLength(); i++) {
                const xy = vertices.getAt(i);

                contentString +=
                    "<br>" + "Coordinate " + i + ":<br>" + xy.lat() + "," + xy.lng();
            }

            // Replace the info window's content and position.
            infoWindow.setContent(contentString);
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
        }

        $(document).ready(function () {
            $.ajax({
                url: "/agents/get_area",
                data: {id: {{$agent->id}}},
                success: function (response) {
                    bounds = new google.maps.LatLngBounds();

                    var poly = [];
                    response.forEach(function (element) {
                        poly.push(new google.maps.LatLng(parseFloat(element[0]), parseFloat(element[1])));

                    });
                    console.log(poly)
                    $('#preloader').fadeOut('slow', function() {
                        $(this).remove();
                    });
                    initMap(poly);

                }
            });
        });
    </script>

@endsection
