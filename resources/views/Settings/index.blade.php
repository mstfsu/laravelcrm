@extends('layouts/contentLayoutMaster')

@section('title', 'Settings')
@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
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
    <style>
        #map {

            height: 400px;
        }
        .map-form{
            border-color: #1976d2;
            background-color: #1976d2;
            color: #fff;
            min-width: 44px;
            width: auto;
        }
    </style>
    <!-- Basic tabs start -->
    <section id="basic-tabs-components">
        <input type="hidden" id="csrf" value="{{csrf_token() }}">

        <div class="row match-height">
            <!-- Basic Tabs starts -->

            <!-- Basic Tabs ends -->

            <!-- Tabs with Icon starts -->
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Settings</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="general_tab_nav" role="tablist">
                            @if(Gate::check('General Settings') || auth()->user()->hasAnyRole(['super admin']))
                            <li class="nav-item">
                                <a
                                        class="nav-link active"
                                        id="general_tab_link "
                                        data-toggle="tab"
                                        href="#general_tab"
                                        aria-controls="home"
                                        url="/ISP/users"
                                        role="tab"
                                        aria-selected="true"
                                ><i data-feather="home"></i> General Settings</a >
                            </li>
                            @endif
                                @if(Gate::check('Notification Settings')  || auth()->user()->hasAnyRole(['super admin']))
                            <li class="nav-item">
                                <a
                                        class="nav-link"
                                        id="profileIcon-tab"
                                        data-toggle="tab"
                                        href="#notificationtab"

                                        aria-controls="profile"
                                        role="tab"

                                        aria-selected="false"
                                ><i data-feather="tool"></i> Notification Settings</a
                                >
                            </li>
                                @endif

                                @if(Gate::check('Reseller Settings')  || auth()->user()->hasAnyRole(['super admin']))
                            <li class="nav-item">
                                <a
                                        class="nav-link"
                                        id=" "
                                        data-toggle="tab"
                                        url="/ISP/users"
                                        href="#reseller_tab"
                                        aria-controls="about"
                                        role="tab"
                                        aria-selected="false"

                                ><i data-feather="map"></i> Reseller Config</a
                                >
                            </li>
                                @endif
                                @if(Gate::check('Billing Settings') || auth()->user()->hasAnyRole(['super admin']))
                            <li class="nav-item">
                                <a
                                        class="nav-link"
                                        id=" "
                                        data-toggle="tab"
                                        url="/ISP/users"
                                        href="#billing_tab"
                                        aria-controls="about"
                                        role="tab"
                                        aria-selected="false"

                                ><i data-feather="map"></i> Billing/Payments</a
                                >
                            </li>
                                @endif
                                @if(Gate::check('Authentication Settings')  || auth()->user()->hasAnyRole(['super admin']))
                            <li class="nav-item">
                                <a
                                        class="nav-link"
                                        id=" "
                                        data-toggle="tab"
                                        url="/ISP/users"
                                        href="#auth_tab"
                                        aria-controls="about"
                                        role="tab"
                                        aria-selected="false"

                                ><i data-feather="map"></i>Authentication</a
                                >
                            </li>
                                @endif
                            @if(\App\Models\Company::gettype()=="Main")
                                    @if(Gate::check('Backup Settings')  || auth()->user()->hasAnyRole(['super admin']))
                            <li class="nav-item">
                                <a
                                        class="nav-link"
                                        id=" "
                                        data-toggle="tab"
                                        url="/ISP/users"
                                        href="#backup_tab"
                                        aria-controls="about"
                                        role="tab"
                                        aria-selected="false"

                                ><i data-feather="map"></i> Backup</a
                                >
                            </li>
                                        @endif
                                @endif

                        </ul>
                        <div class="tab-content">
                            @if(Gate::check('General Settings') || auth()->user()->hasAnyRole(['super admin']))
                            <div class="tab-pane active" id="general_tab" aria-labelledby="general_tab-tab" role="general_tab">
                                @include('Settings.Tabs.general')
                            </div>
                            @endif
                            @if(Gate::check('Notification Settings') || auth()->user()->hasAnyRole(['super admin']))
                            <div class="tab-pane  " id="notificationtab" aria-labelledby="notificationtab-tab" role="notificationtab">
                                @include('Settings.Tabs.notification')
                            </div>
                            @endif
                            @if(Gate::check('Reseller Settings')  || auth()->user()->hasAnyRole(['super admin']))
                            <div class="tab-pane  " id="reseller_tab" aria-labelledby="reseller_tab-tab" role="reseller_tab">
                                @include('Settings.Tabs.reseller')
                            </div>
                            @endif
                            @if(Gate::check('Billing Settings') || auth()->user()->hasAnyRole(['super admin']))
                            <div class="tab-pane  " id="billing_tab" aria-labelledby="reseller_tab-tab" role="reseller_tab">
                                @include('Settings.Tabs.billing')
                            </div>
                            @endif
                            @if(Gate::check('Authentication Settings')  || auth()->user()->hasAnyRole(['super admin']))
                            <div class="tab-pane  " id="auth_tab" aria-labelledby="backup_tab-tab" role="auth_tab">
                                @include('Settings.Tabs.auth')
                            </div>
                            @endif
                            @if(\App\Models\Company::gettype()=="Main")
                                @if(Gate::check('Backup Settings') || auth()->user()->hasAnyRole(['super admin']))
                            <div class="tab-pane  " id="backup_tab" aria-labelledby="backup_tab-tab" role="backup_tab">
                                @include('Settings.Tabs.backup')
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs with Icon ends -->
        </div>
    </section>

    <!-- Basic Tabs end -->

    <!-- Vertical Tabs start -->

    <!-- Vertical Tabs end -->



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
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

@endsection

@section('page-script')
    <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>


    <script src="{{ asset('js/scripts/Settings/general.js') }}"></script>
    <script src="{{ asset('js/scripts/Settings/notification.js') }}"></script>
    <script src="{{ asset('js/scripts/Settings/reseller.js') }}"></script>
    <script src="{{ asset('js/scripts/Settings/billing.js') }}"></script>
    <script src="{{ asset('js/scripts/Settings/backup.js') }}"></script>
    <script src="{{ asset('js/scripts/Settings/auth.js') }}"></script>
    <script>
        Echo.channel('activities')
            .listen('.activity-monitor', (e) => {
                console.log(e);
            });
        window.Echo.channel('UserCount')
            .listen('UserscountEvent', (e) => {
                console.log(e);
                console.log('test');
            });
        window.Echo.channel('UserCount')
            .listen('.UserscountEvent', (e) => {
                console.log(e);
                console.log('test');
            });
        Echo.channel('predisactivities')
            .listen('.activity-monitor', e => {
                console.log("sddsfsdfsdfsfd")
                console.log("dsfsdfsdf")
            })
        Echo.connector.socket.on('connect', () => {
            console.log("dsfsdfsdf")
        });
        window.Echo.connector.socket.on('disconnect', () => {
            //your code
            console.log("dsfsdfsdf")
        });
    </script>
@endsection
