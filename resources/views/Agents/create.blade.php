@extends('layouts/contentLayoutMaster')

@section('title', 'Agent')
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
                        <h4 class="card-title">Create Agent</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="mikrotik_tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="homeIcon-tab"
                                   data-toggle="tab"
                                   href="#tickets"
                                   aria-controls="home"
                                   role="tab"
                                   aria-selected="true"
                                ><i data-feather="file-text"></i> Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="aboutIcon-tab"
                                   data-toggle="tab"
                                   href="#maptab"
                                   aria-controls="about"
                                   role="tab"
                                   aria-selected="false"

                                ><i data-feather="map"></i> MAP</a>
                            </li>

                        </ul>
                        <form class="form" action="{{route('agents.store')}}" method="POST">
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane active " id="tickets" aria-labelledby="information-tab"
                                     role="tabpanel">
                                    <div class="card">
                                        @if($errors->any())
                                          <span class="col-md-6 badge badge-danger">{!! implode('', $errors->all('<div>:message</div>')) !!}</span>
                                        @endif
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <div class="mb-1">
                                                                    <label class="form-label" for="first-name-column">Name</label>
                                                                    <input type="text" id="first-name-column"
                                                                           class="form-control" placeholder="Type Name"
                                                                           name="name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="mb-1">
                                                                    <label class="form-label" for="email-id-column">Email</label>
                                                                    <input type="email" id="email-id-column"
                                                                           class="form-control" name="email"
                                                                           placeholder="email">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="mb-1">
                                                                    <label class="form-label" for="last-name-column">Password</label>
                                                                    <input type="password" id="last-name-column"
                                                                           class="form-control"
                                                                           placeholder="Type Password" name="password">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="mb-1">
                                                                    <label class="form-label" for="last-name-column">Password Confirmed</label>
                                                                    <input type="password" id="last-name-column"
                                                                           class="form-control"
                                                                           placeholder="Type Password" name="password_confirmation">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="mb-1">
                                                                    <label class="form-label"
                                                                           for="city-column">Phone</label>
                                                                    <input type="text" id="city-column"
                                                                           class="form-control" placeholder="Phone"
                                                                           name="phone">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="maptab" aria-labelledby="aboutIcon-tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div id="map"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form-label" for="basic-icon-default-email">Area</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-outline-primary waves-effect map-form"
                                                                        id="area_btn" type="button"><i
                                                                            data-feather="map-pin"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" class="form-control" required id="area_txt"
                                                                name="area"
                                                                placeholder="100" aria-label="Speed(Upload)"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form-label" for="country">Country</label>
                                                        <select  class="form-control" id="country">
                                                          <option value="IN">India</option>
                                                          <option value="UK">United Kingdom</option>
                                                          <option value="USA">USA</option>
                                    
                                                        </select>
                                                      </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form-label" for="landmark">PinCode</label>
                                                        <input type="text" name="pincode" id="pincode"    @if(\App\Models\Settings::get('user_pincode') =='true') required @endif class="form-control" placeholder="PinCode" />
                                                      </div>
                                                </div>
                                                
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div class="col-12">
                                                            <button type="submit"
                                                                    class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

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
        var map; // Global declaration of the map
        var iw = new google.maps.InfoWindow(); // Global declaration of the infowindow
        var lat_longs = new Array();
        var markers = new Array();
        var drawingManager;
        geocoder = new google.maps.Geocoder();

        function geo(country,zip) {
            google.maps.event.addDomListener(window, 'load', initialize);

            geocoder.geocode({'address': zip,'country':country}, function (results, status) {


        if (status == google.maps.GeocoderStatus.OK) {
          //Got result, center the map and put it out there

          var indice = 0;


          for (var i = 0; i < results[0].address_components.length; i++) {
            if (results[0].address_components[i].types[0] == "locality") {
              //this is the object you are looking for City
              city = results[0].address_components[i];
            }
            if (results[0].address_components[i].types[0] == "administrative_area_level_1") {
              //this is the object you are looking for State
              state = results[0].address_components[i];
            }
            if (results[0].address_components[i].types[0] == "country") {
              //this is the object you are looking for
              country = results[0].address_components[i];
            }
          }

          //city data


          map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
          });

        } else {
          //alert("Geocode was not successful for the following reason: " + status);
        }
      });
    }
        function initialize() {
            var myLatlng = new google.maps.LatLng(40.9403762, -74.1318096);
            var myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP}
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, "polygoncomplete", function(event){
                $('#area_txt').val(event.getPath().getArray().toString());
            });
        }
        initialize();
        $('#country').on('change',function(){
            var country=$(this).val();
            var zip=$('#pincode').val()
            geo(country,zip)

        });
        $("#pincode").keyup(function(){
            var zip=$(this).val();
            var country=$('#country').val()
            geo(country,zip)
        });

    </script>

@endsection
