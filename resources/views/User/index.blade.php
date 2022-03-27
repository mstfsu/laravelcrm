@extends('layouts/contentLayoutMaster')

@section('title', 'Admins List')

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

        .plan_form{
            border-color: #1976d2;
            background-color: #1976d2;
            color: #fff;
            min-width: 44px;
            width: auto;
        }
    </style>
@endsection

@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter start -->

        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <input type="hidden" id="csrf" value="{{csrf_token() }}">
            <div class="card-datatable table-responsive pt-0">

                <table class="admin-list-table table">

                    <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>email </th>

                        <th>Role</th>
                        <th>Zone</th>
                        <th>Created At</th>

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-device-modal fade" id="modals-slide-in">
                <div class="modal-dialog" style="width: 70%">

                    <form class="add-new-device modal-content pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="basic-icon-default-fullname">Device Name</label>
                                        <input
                                                type="text"
                                                class="form-control "
                                                id="device_name"
                                                placeholder="Mikrotik1"
                                                name="device_name"
                                                aria-label="Mikrotik"
                                                aria-describedby="basic-icon-default-fullname2"
                                        />
                                    </div>
                                    <div class="form-group col-md-12">

                                        <div class="form-group">
                                            <label class="form-label" for="basic-icon-default-email">Description</label>
                                            <div class="input-group mb-2">


                                                <input type="text" class="form-control"  id="description" name="description" placeholder="Descriptionnew-device-modal" aria-label="Description" />

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="basic-icon-default-email">IP Address</label>
                                            <div class="input-group mb-2">


                                                <input type="text" class="form-control" id="ip" name="ip" placeholder="100" aria-label="192.168.1.1" />

                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="form-label" for="basic-icon-default-email">PinCode</label>
                                            <div class="input-group mb-2">


                                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="100" aria-label="110001" />

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="basic-icon-default-email">latitude</label>
                                            <div class="input-group mb-2">


                                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="100" aria-label="lattitude" />

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="basic-icon-default-email">Longitude</label>
                                            <div class="input-group mb-2">


                                                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="100" aria-label="Price" />

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="form-label" for="basic-icon-default-email">Partner</label>

                                            <select class="select2 form-control  "  multiple="multiple"  id="partner_select" name="partner_select">


                                            </select>
                                        </div>
                                    </div>




                                    <button type="submit" id="add_plan_btn" status='add' class="btn btn-primary mr-1 data-submit">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="map-canvas"  style=" height: 100%;
 margin: 0px;
      padding: 0px;position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new user Ends-->
        </div>
        <!-- list section end -->
    </section>

    <!---------------------Core Modal------------------>
    <div class="modal fade text-left" id="changepasswordmodal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true"  >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Change Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body card card-transaction">
                    <form id="changepasswordform">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label" for="latitude">New Password</label>
                            <input type="hidden" name="admin_id" id="admin_id">
                            <input type="password" id="password" name="password"class="form-control"  />
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="city1">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control"     />
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light" >Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- users list ends -->
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
    <script type="text/javascript"
            src="{your google map key}">
    </script>
@endsection

@section('page-script')
    {{-- Page js files --}}

    <script src="{{ asset('js/scripts/User/script.js') }}"></script>
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

        }


        function placeMarker(location) {
            if (!marker || !marker.setPosition) {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
                var icon = {
                    url: "{{ asset("images/icons/device.png" )}}", // url
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




            infowindow.open(map, marker);
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function geo( zip) {
            google.maps.event.addDomListener(window, 'load', initialize);

            geocoder.geocode({'address': zip }, function (results, status) {
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


                } else {
                    alert("Geocode was not successful for the following reason: " + status);
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
            geo(zip)
        });

    </script>

@endsection
