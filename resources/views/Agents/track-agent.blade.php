@extends('layouts/contentLayoutMaster')

@section('title')
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      Filter Options
                                    </a>
                                  </p>
                                  <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label" for="first-name-vertical">Agent</label>
                                                <select id="agentSelect"
                                                        class="select2 form-control livesearch form-control-lg select2-hidden-accessible"
                                                        tabindex="-1" aria-hidden="true" name="customer_id">
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="first-name-vertical">Date</label>
                                                <select id="dateSelect"
                                                        class="select2 select-other form-control form-control-lg select2-hidden-accessible"
                                                        tabindex="-1" aria-hidden="true">
                                                        <option value="1">Last One Hour</option>
                                                        <option value="6">Last Six Hour</option>
                                                        <option value="1">Today</option>
                                                        <option value="7">Last Week</option>
                                                        <option value="30">Last Month</option>
                                                        <option value="90">3 months ago</option>
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="card-footer text-muted">
                                        <a href="#" onclick="getMap()" class="btn btn-warning float-right">Get Map</a>
                                    </div>
                                  </div>
                            </div>
                            
                            <div hidden id="mapdiv" class="col-md-12 mt-2">
                                <div id="preloader" class="d-flex justify-content-center">
                                    <div class="spinner-border" hidden role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="map" style="height: 700px!important"></div>
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
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js" integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous"></script>

    <script type="text/javascript">

        function initMap(poly,isOnePoint,agentId) {
            
            const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: poly[0].point,
                });
            if(isOnePoint){
                new google.maps.Marker({
                    position: poly[0].point,
                    map,
                    title: new Date(poly[0].date).toLocaleString(),
                    label: "1"
                });
            }else{
                const lineSymbol = {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 8,
                    strokeColor: "#393",
                };
                const infoWindow = new google.maps.InfoWindow();
                for (var i = 0; i < poly.length; i++) {
                    var date = new Date(poly[i].date);
                    const marker = new google.maps.Marker({
                        position: poly[i].point,
                        map,
                        title: date.toLocaleString(),
                        label: `${i + 1}`,
                        optimized: false,
                        animation: google.maps.Animation.DROP,
                        draggable: true,
                    });
                    // Add a click listener for each marker, and set up the info window.
                    marker.addListener("click", () => {
                        infoWindow.close();
                        infoWindow.setContent(marker.getTitle());
                        infoWindow.open(marker.getMap(), marker);
                    });
                }
                const flightPath = new google.maps.Polyline({
                    path: poly.map(p => p.point),
                    geodesic: true,
                    strokeColor: "#FF0000",
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    icons: [
                        {
                            icon: lineSymbol,
                            offset: "100%",
                        },
                    ],
                });

                flightPath.setMap(map);
                animateCircle(flightPath);

                var markerCount = poly.length;
                var app_url = '{{getenv("APP_URL")}}' ;
                let user_id= {{\Illuminate\Support\Facades\Auth::id()}} ;
                var socket = io(app_url+':3000', { transports : ['websocket'] });
                socket.on('connect',function (){
                    socket.emit("agent_mobile",agentId,"web");
                });
                socket.on("mobil-channel:App\\Events\\GetMapInfoEvent",function (location){
                    markerCount++;
                    var path = flightPath.getPath();    
                    path.push(new google.maps.LatLng(parseFloat(location.data.data.latitude) ,parseFloat(location.data.data.longitude) ));  
                    // Add a new marker at the new plotted point on the polyline.  
                    
                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var dateTime = date+' '+time;
                    var marker = new google.maps.Marker({  
                        position: new google.maps.LatLng(parseFloat(location.data.data.latitude) ,parseFloat(location.data.data.longitude) ),  
                        title: ''+dateTime,
                        map: map  ,
                        label: `${markerCount}`,
                    });
                    marker.addListener("click", () => {
                        infoWindow.close();
                        infoWindow.setContent(marker.getTitle());
                        infoWindow.open(marker.getMap(), marker);
                    });
                });
            }  
        }

        function getMap(){
            var agentId = $('#agentSelect').select2('data')[0].id;
            var date = $('#dateSelect :selected');

            var data = {
                id:agentId,
                dateOption:date.val()
            };
            if(date.text().includes('Hour')){
                data.dateType="hour";
            }
            $.ajax({
                url: "/agents/get_agent_map_infos",
                data: data,
                success: function (response) {

                    var poly = [];

                    if(response.length>1){
                        $('#mapdiv').removeAttr('hidden');
                        $('#preloader').removeAttr('hidden');
                        bounds = new google.maps.LatLngBounds();
                        response.forEach(function (element) {
                            var data = {
                                point :new google.maps.LatLng(parseFloat(element.latitude) ,parseFloat(element.longitude) ),
                                date: element.created_at 
                            }
                            poly.push(data);
                        });
                        $('#preloader').fadeOut('slow', function() {
                            $(this).remove();
                        });
                        initMap(poly,false,agentId);
                    }else if(response.length==1){
                        $('#mapdiv').removeAttr('hidden');
                        $('#preloader').removeAttr('hidden');
                        var data = {
                                point :new google.maps.LatLng(parseFloat(response[0].latitude) ,parseFloat(response[0].longitude) ),
                                date: response[0].created_at 
                            }
                        poly.push(data);
                        initMap(poly,true,agentId);
                    }else{
                        toastr['error']('There is no information about agent. You can change filter options', {
                            closeButton: true,
                            tapToDismiss: false,
                        });
                    }
                }
            });

        }
    $(document).ready(function () {
        $('.livesearch').select2({
            placeholder: 'Type Agent Name',
            ajax: {
                url: '/agents/get_agent_info',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text:item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.select-other').select2();
    });
    function animateCircle(line) {
            let count = 0;

            window.setInterval(() => {
                count = (count + 1) % 200;

                const icons = line.get("icons");

                icons[0].offset = count / 2 + "%";
                line.set("icons", icons);
            }, 20);
        }
    </script>
    
@endsection
