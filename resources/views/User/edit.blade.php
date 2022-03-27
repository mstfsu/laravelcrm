
@extends('layouts/contentLayoutMaster')

@section('title', "Edit Admin $details->name  ")

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset('Plugins/countries/mobiscroll.jquery.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">

@endsection

@section('content')
    <!-- Horizontal Wizard -->
    <section class="horizontal-wizard">
        <div class="bs-stepper horizontal-wizard-example">
            <div class="bs-stepper-header">
                <div class="step" data-target="#account-details">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">1</span>
                        <span class="bs-stepper-label">
            <span class="bs-stepper-title">Login Details</span>
            <span class="bs-stepper-subtitle">Setup Login Details</span>
          </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#personal-info">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">2</span>
                        <span class="bs-stepper-label">
            <span class="bs-stepper-title">Personal Info</span>
            <span class="bs-stepper-subtitle">Add Personal Info</span>
          </span>
                    </button>
                </div>


                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#social-links">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">3</span>
                        <span class="bs-stepper-label">
            <span class="bs-stepper-title">Upload Avatar</span>
            <span class="bs-stepper-subtitle">Upload Admmin's Avatar</span>
          </span>
                    </button>
                </div>

            </div>
            <div class="bs-stepper-content">
                <div id="account-details" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">Account Details</h5>
                        <small class="text-muted">Enter Your Account Details.</small>
                    </div>
                    <form>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label" for="username">Email</label>
                                <input type="hidden" name="admin_id" id="admin_id"   value="{{$details->id}}"/>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email"  value="{{$details->email}}"/>
                            </div>

                        </div>

                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-secondary btn-prev" disabled>
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="personal-info" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">Personal Info</h5>
                        <small>Enter Your Personal Info.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="owner">Company</label>
                                        <select id="company" name="company" class="form-control">
                                            <option >None</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="full-name">Full Name</label>
                                        <input type="text" name="full-name" id="full-name" class="form-control" placeholder="John" value="{{$details->name}}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="phone">Mobile Number</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="xxx-xxx-xxxx"value="{{$details->profile->mobile}}" />
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="country">Role</label>
                                        <select  class="form-control" id="role">
                                            @foreach($roles as $role)
                                                @if($userRoles->id== $role->id)
                                                <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                                @else
                                                    <option value="{{$role->id}}"  >{{$role->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="country">Country</label>
                                        <select  class="form-control" id="country">
                                            <option value="IN">India</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="USA">USA</option>

                                        </select>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="landmark">PinCode</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control" placeholder="PinCode" value=" {{$details->profile->pincode}}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="country">State</label>
                                        <input
                                                type="text"
                                                name="state"
                                                id="state"
                                                class="form-control"
                                                placeholder="State"
                                                aria-label="State"
                                                value="{{$details->profile->state}}"
                                        />
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="country">City</label>
                                        <input
                                                type="text"
                                                name="city"
                                                id="city"
                                                class="form-control"
                                                placeholder="City"
                                                aria-label="city"
                                                value="{{$details->profile->city}}"
                                        />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="address">Address</label>
                                        <input
                                                type="text"
                                                id="address"
                                                name="address"
                                                class="form-control"
                                                placeholder="98  Borough bridge Road, Birmingham"
                                                value="{{$details->profile->address}}"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="latitude">Latitude</label>
                                        <input type="text" id="latitude" class="form-control" placeholder="658921" value="{{$details->profile->latitude}}"  />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="city1">Longitude</label>
                                        <input type="text" id="longitude" class="form-control" placeholder="658921" value="{{$details->profile->longitude}}" />
                                    </div>
                                </div>



                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none">Next</span>
                                    <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                                </button>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div id="map-canvas"  style=" height: 100%;
 margin: 0px;
      padding: 0px;position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>


                        </div>

                    </div>


                </div>


                <div id="social-links" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">Documentation Proof</h5>
                        <small>Insert Documentation that required for Proof account.</small>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Upload  Avatar </h4>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="_token"  id="_token"content="{{csrf_token()}}">
                                        <a href="javascript:void(0);" class="mr-25">
                                            <img src="{{$details->profile->avatar}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80">
                                        </a>
                                        <div class="media-body mt-75 ml-1">
                                            <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                            <input type="file" id="account-upload" hidden accept="image/*" />
                                            <button class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                                            <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-success btn-submit" id="User_Submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Horizontal Wizard -->

    <!-- Vertical Wizard -->

    <!-- /Vertical Wizard -->




    <!-- /Modern Vertical Wizard -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script type="text/javascript"
            src="{your google map key}">
    </script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset( 'Plugins/countries/mobiscroll.jquery.min.js') }}"></script>
    <script src="{{ asset( 'js/scripts/User/edit.js') }}"></script>
    <script>
        var remoteData = {
            url: 'https://trial.mobiscroll.com/content/countries.json',
            type: 'json'
        };
        $.each(remoteData,function(key, value)
        {
            $('#country').append('<option value=' + key + '>' + value + '</option>');
        });


    </script>
    <script type="text/javascript">
        geocoder = new google.maps.Geocoder();
        var map;
        var myCenter = new google.maps.LatLng(51.508742, -0.120850);
        var marker;
        var infowindow;
        function initialize() {

            var mapProp = {
                center: myCenter,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });
            if($('#latitude').val()!='' || $('#longitude').val()!="")
            {centerfromlonglat();}
        }


        function placeMarker(location) {
            if (!marker || !marker.setPosition) {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
                var icon = {
                    url: "{{ asset("images/icons/user.png" )}}", // url
                    scaledSize: new google.maps.Size(50, 50), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                };
                marker.setIcon(icon);
            } else {
                marker.setPosition(location);
            }
            if (!!infowindow && !!infowindow.close) {
                infowindow.close();
            }

            infowindow = new google.maps.InfoWindow({

                content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()

            });
            $('#latitude').val(location.lat())
            $('#longitude').val(location.lng())
            var latlng = new google.maps.LatLng(location.lat(), location.lng());
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        $('#address').val( results[1].formatted_address)

                    }
                }
            });


            infowindow.open(map, marker);
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function geo(country,zip) {
            google.maps.event.addDomListener(window, 'load', initialize);

            geocoder.geocode({'address': zip,'country':country}, function (results, status) {
                console.log(results[0].formatted_address)


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
                    $('#city').val(city.long_name)
                    $('#state').val(state.long_name)

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
        function centerfromlonglat(){

            var latlng = new google.maps.LatLng($('#latitude').val(), $('#longitude').val());
            console.log(latlng)
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        map.setCenter(results[0].geometry.location);
                        placeMarker( latlng);

                    }
                }
            });

        }


        $('#country').on('change',function(){
            var country=$(this).val();
            var zip=$('#pincode').val()
            geo(country,zip)

        })
        $("#pincode").keyup(function(){
            var zip=$(this).val();
            var country=$('#country').val()
            geo(country,zip)
        });

    </script>


@endsection
