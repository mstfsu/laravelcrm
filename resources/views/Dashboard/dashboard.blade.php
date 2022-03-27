
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
    {{-- vendor css files --}}


    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">


@endsection
@section('page-style')
    {{-- Page css files --}}

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <style>
        .apexcharts-xaxis{
            display:none
        }
        .primarycard{
            background-image: linear-gradient(
                    80deg,#7367f0,#9e95f5);
            color:#ffff;
        }

        .warningcard{
            background-image: linear-gradient(
                    80deg,#fd7602,#ffa536);
            color:#ffff;
        }
        .expiredcard{
            background-image: linear-gradient(
                    80deg,#d2b1c5,#8c01af);
            color: #ffff;
        }
        .expiredh3{
            color:#8c01af;
        }
        .dangercard{
            background-image:linear-gradient(
                    80deg,#8c5454,#ff6e36);
            color:#ffff;
        }
        .dangerh3{
            color:#8c5454;
        }
        .infocard{
            background-image:linear-gradient(
                    80deg,#088eec,#1776b9);
            color:#ffff;
        }
        .infoh3{
            color:#088eec;
        }
        .successcard{
            background-image: linear-gradient(
                    80deg,#355f2b,#2caf01);
            color:#ffff;
        }
        .successh3{
            color:#355f2b;
        }
        .icondash{
            width:42px;
            height:42px
        }
    </style>
@endsection

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        @if((Gate::check('View Dashboard') || auth()->user()->hasAnyRole(['super admin'])) )
        <div class="row match-height">
            <!-- Medal Card -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header infocard" >
                        <div >
                            <div class="avatars bg-light-warnings icondash p-50 m-0">
                                <div class="avatar-content">
                                    <i  class="font-medium-5 fas  fa-user-plus fa-lg"></i>
                                </div>
                            </div>                            <p class="card-text"></p>
                        </div>
                        <div >
                            <a href="/ISPUsers/list/new" class="infoh3">  <h2 class="font-weight-bolder mb-0" style=" color:#ffff;">{{$totalregisteration}}</h2></a>
                            <a href="/ISPUsers/list/new" class="infoh3">  <p class="card-text"style=" color:#ffff;">Registration </p></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="infoh3 " >

                                    <a href="/ISPUsers/list/all?date=today&type=new" class="infoh3"> <span>{{$registeration}}</span></a>
                                </h4>
                            </div>
                            <div class="col-4">
                                <h4 class="infoh3 ">

                                    <a href="/ISPUsers/list/all?date=week&type=new" class="infoh3"> <span>{{$registeration_week}}</span></a>
                                </h4>
                            </div>
                            <div class="col-4">
                                <h4 class="infoh3 " >

                                    <a href="/ISPUsers/list/all?date=month&type=new" class="infoh3" > <span>{{$registeration_month}}</span></a>
                                </h4>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5 class="infoh3 " >
                                    <a href="/ISPUsers/list/all?date=today&type=new" class="infoh3">Today </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="infoh3 ">
                                    <a href="/ISPUsers/list/all?date=week&type=new" class="infoh3">Week </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="infoh3 " >
                                    <a href="/ISPUsers/list/all?date=month&type=new" class="infoh3" >Month </a>

                                </h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--/ Medal Card -->

            <!-- Statistics Card -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header successcard" >
                        <div >
                            <div class="avatars bg-light-successs  icondash p-50 m-0">
                                <div class="avatar-content">

                                    <i  class="font-medium-5 fa fa-user-check"></i>
                                </div>
                            </div>                                <p class="card-text"></p>
                        </div>
                        <div >
                            <a href="/ISPUsers/list/active" class="successh3">   <h2 class="font-weight-bolder mb-0" style=" color:#ffff;" >{{$totalactive}}</h2></a>
                            <a href="/ISPUsers/list/active" class="successh3">  <p class="card-text" style=" color:#ffff;">Active </p></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <h5 class="successh3 ">

                                    <a href="/ISPUsers/list/all?date=today&type=active" class="successh3"> <span>{{$active_daily}}</span></a>
                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="successh3">

                                    <a href="/ISPUsers/list/all?date=week&type=active" class="successh3"><span>{{$active_week}}</span></a>
                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="successh3 " >

                                    <a href="/ISPUsers/list/all?date=month&type=active" class="successh3" ><span>{{$active_month}}</span></a>
                                </h5>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5 class="successh3 ">
                                    <a href="/ISPUsers/list/all?date=today&type=active" class="successh3">Today </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="successh3">
                                    <a href="/ISPUsers/list/all?date=week&type=active" class="successh3">Week </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="successh3 " >
                                    <a href="/ISPUsers/list/all?date=month&type=active" class="successh3" >Month </a>

                                </h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="col-lg-3 col-sm-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header warningcard" >--}}
{{--                        <div >--}}
{{--                            <div class="avatar bg-light-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i data-feather="users" class="font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>                              <p class="card-text">Renewal</p>--}}
{{--                        </div>--}}
{{--                        <div >--}}
{{--                            <h2 class="font-weight-bolder mb-0" style=" color:#ffff;">{{$renew_daily}}</h2>--}}
{{--                            <p class="card-text">Today</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-footer">--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-6">--}}
{{--                                <h4 class=" ">--}}
{{--                                    <a href="javascript:void(0);">Week:</a>--}}
{{--                                    <span>{{$renew_week}}</span>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <h4 class=" "style="float: right">--}}
{{--                                    <a href="javascript:void(0);" >Month:</a>--}}
{{--                                    <span>{{$renew_month}}</span>--}}
{{--                                </h4>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header expiredcard" >
                        <div >
                            <div >
                                <div class="avatars bg-light-primarys icondash p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="font-medium-5 fa fa-clock"></i>
                                    </div>
                                </div>

                            </div>                            <p class="card-text"></p>
                        </div>
                        <div >
                            <a href="/ISPUsers/list/expired" class="expiredh3">   <h2 class="font-weight-bolder mb-0" style=" color:#ffff;" >{{$totalexpire}}</h2></a>
                            <a href="/ISPUsers/list/expired" class="expiredh3"> <p class="card-text" style=" color:#ffff;" >Expired </p></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <h5 class="expiredh3">

                                    <a href="/ISPUsers/list/all?date=today&type=expired" class="expiredh3"> <span>{{$expired_daily}}</span></a>
                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="expiredh3 ">

                                    <a href="/ISPUsers/list/all?date=week&type=expired" class="expiredh3">  <span>{{$expired_week}}</span></a>
                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="expiredh3 " >

                                    <a href="/ISPUsers/list/all?date=month&type=expired"  class="expiredh3" >  <span>{{$expired_month}}</span></a>
                                </h5>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5 class="expiredh3" >
                                    <a href="/ISPUsers/list/all?date=today&type=expired" class="expiredh3">Today </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="expiredh3 ">
                                    <a href="/ISPUsers/list/all?date=week&type=expired" class="expiredh3">Week </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="expiredh3 " >
                                    <a href="/ISPUsers/list/all?date=month&type=expired"  class="expiredh3" >Month </a>

                                </h5>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header dangercard" >
                        <div >
                            <div class="avatars bg-light-infos icondash p-50 m-0">
                                <div class="avatar-content">

                                    <i  class="font-medium-5 fa fa-user-times"></i>
                                </div>
                            </div>
                            <p class="card-text"></p>
                        </div>
                        <div >
                            <a href="/ISPUsers/list/blocked"  class="dangerh3">   <h2 class="font-weight-bolder mb-0"  style=" color:#ffff;" >{{$block_total}}</h2></a>
                            <a href="/ISPUsers/list/blocked"  class="dangerh3">  <p class="card-text"  style=" color:#ffff;"  > Blocked</p></a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <h5 class="dangerh3">

                                    <a href="/ISPUsers/list/all?date=today&type=blocked"  class="dangerh3">  <span>{{$block_daily}}</span></a>
                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="dangerh3 ">

                                    <a href="/ISPUsers/list/all?date=week&type=blocked" class="dangerh3">  <span>{{$block_week}}</span></a>
                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="dangerh3 " >

                                    <a href="/ISPUsers/list/all?date=month&type=blocked"  class="dangerh3" >   <span>{{$block_month}}</span></a>
                                </h5>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5 class="dangerh3">
                                    <a href="/ISPUsers/list/all?date=today&type=blocked"  class="dangerh3">Today </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="dangerh3 ">
                                    <a href="/ISPUsers/list/all?date=week&type=blocked" class="dangerh3">Week </a>

                                </h5>
                            </div>
                            <div class="col-4">
                                <h5 class="dangerh3 " >
                                    <a href="/ISPUsers/list/all?date=month&type=blocked"  class="dangerh3" >Month </a>

                                </h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="col-lg-3 col-sm-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header primarycard" >--}}
{{--                        <div >--}}
{{--                            <div class="avatar bg-light-success  p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}

{{--                                    <i data-feather="users" class="font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <p class="card-text">Upcoming Renewal</p>--}}
{{--                        </div>--}}
{{--                        <div >--}}
{{--                            <h2 class="font-weight-bolder mb-0" style=" color:#ffff;">{{$expired_daily}}</h2>--}}
{{--                            <p class="card-text">Today</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-footer">--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-6">--}}
{{--                                <h4 class=" ">--}}
{{--                                    <a href="javascript:void(0);">Week:</a>--}}
{{--                                    <span>{{$expired_week}}</span>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="col-6">--}}
{{--                                <h4 class=" "style="float: right">--}}
{{--                                    <a href="javascript:void(0);" >Month:</a>--}}
{{--                                    <span>{{$expired_month}}</span>--}}
{{--                                </h4>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


            <!--/ Statistics Card -->
        </div>
        <div class="row match-height">

            <div class="col-12  col-lg-6 col-md-6">
                <div class="card">
                    <div
                            class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start"
                    >
                        <div>
                            <h4 class="card-title">Online Users</h4>

                        </div>
                        <div class="d-flex align-items-center">
                            <select name="online_range" id="online_range" class="form-control">
                            <option value="1Hour">1Hour</option>
                            <option value="6Hour">6Hours</option>
                            <option value="12Hour">12Hours</option>
                            <option value="24Hour">24Hours</option>
                            <option value="Today">Today</option>
                            <option value="Yesterday">Yesterday</option>
                            <option value="Week">This Week</option>
                            <option value="Month">This Month</option>
                            </select>



                        </div>
                    </div>
                    <div class="card-body">
{{--                        {!! $onlinechart->container() !!}--}}
                        <div id="line-area-chart" style="min-height: 300px;"></div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h4 class="card-title">Support Tracker</h4>
{{--                        <div>--}}
{{--                            <select name="companies" id="compaies" class="form-control">--}}
{{--                                @foreach($companies as $company)--}}
{{--                                    <option value="{{$company->id}}">{{$company->name}}</option>--}}
{{--                                    @endforeach--}}

{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="dropdown chart-dropdown">--}}
{{--                            <button--}}
{{--                                    class="btn btn-sm border-0 dropdown-toggle p-50"--}}
{{--                                    type="button"--}}
{{--                                    id="dropdownItem4"--}}
{{--                                    data-toggle="dropdown"--}}
{{--                                    aria-haspopup="true"--}}
{{--                                    aria-expanded="false"--}}
{{--                            >--}}
{{--                                Last 7 Days--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">--}}
{{--                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>--}}
{{--                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>--}}
{{--                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                <h1 class="font-large-2 font-weight-bolder mt-2 mb-0">{{$total_tickets}}</h1>
                                <p class="card-text">Total Tickets</p>
                            </div>
                            <div class="col-sm-10 col-12 d-flex justify-content-center">
                                <div id="support-trackers-chart"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <div class="text-center">
                                <p class="card-text mb-50">New Tickets</p>
                                <span class="font-large-1 font-weight-bold">{{$new_tickets}}</span>
                            </div>
                            <div class="text-center">
                                <p class="card-text mb-50">Opened Tickets</p>
                                <span class="font-large-1 font-weight-bold">{{$opened_tickets}}</span>
                            </div>

                            <div class="text-center">
                                <p class="card-text mb-50">Closed Tickets</p>
                                <span class="font-large-1 font-weight-bold">{{$closed_tickets}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics Card -->
        </div>
        <div class="row match-height">
            <!-- Avg Sessions Chart Card starts -->
{{--            <div class="col-lg-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row pb-50">--}}
{{--                            <div class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">--}}
{{--                                <div class="mb-1 mb-sm-0">--}}
{{--                                    <h2 class="font-weight-bolder mb-25" id="total_leads">0</h2>--}}
{{--                                    <p class="card-text font-weight-bold mb-2">Total</p>--}}
{{--                                    <div class="font-medium-2">--}}
{{--                                        <span id="avg_leads" class="text-success mr-25">0%</span>--}}
{{--                                        <span>vs last 7 days</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="col-sm-6 col-12 d-flex justify-content-between flex-column text-right order-sm-2 order-1">--}}
{{--                                <div class="dropdown chart-dropdown">--}}
{{--                                    <button--}}
{{--                                            class="btn btn-sm border-0 dropdown-toggle p-50"--}}
{{--                                            type="button"--}}
{{--                                            id="dropdownItem5"--}}
{{--                                            data-toggle="dropdown"--}}
{{--                                            aria-haspopup="true"--}}
{{--                                            aria-expanded="false"--}}
{{--                                    >--}}
{{--                                        Last 7 Days--}}
{{--                                    </button>--}}
{{--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem5">--}}

{{--                                        <a class="dropdown-item" href="javascript:void(0);">This Month</a>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div id="avg-sessions-chart"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <hr />--}}
{{--                        <div class="row avg-sessions pt-50" id="lead_block">--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Avg Sessions Chart Card ends -->

            <!-- Support Tracker Chart Card starts -->
{{--            <div class="col-lg-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header d-flex justify-content-between pb-0">--}}
{{--                        <h4 class="card-title">Support Tracker</h4>--}}
{{--                        <div class="dropdown chart-dropdown">--}}
{{--                            <button--}}
{{--                                    class="btn btn-sm border-0 dropdown-toggle p-50"--}}
{{--                                    type="button"--}}
{{--                                    id="dropdownItem4"--}}
{{--                                    data-toggle="dropdown"--}}
{{--                                    aria-haspopup="true"--}}
{{--                                    aria-expanded="false"--}}
{{--                            >--}}
{{--                                Last 7 Days--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">--}}
{{--                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>--}}
{{--                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>--}}
{{--                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">--}}
{{--                                <h1 class="font-large-2 font-weight-bolder mt-2 mb-0">{{$total_tickets}}</h1>--}}
{{--                                <p class="card-text">Total Tickets</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-10 col-12 d-flex justify-content-center">--}}
{{--                                <div id="support-trackers-chart"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex justify-content-between mt-1">--}}
{{--                            <div class="text-center">--}}
{{--                                <p class="card-text mb-50">New Tickets</p>--}}
{{--                                <span class="font-large-1 font-weight-bold">{{$new_tickets}}</span>--}}
{{--                            </div>--}}
{{--                            <div class="text-center">--}}
{{--                                <p class="card-text mb-50">Opened Tickets</p>--}}
{{--                                <span class="font-large-1 font-weight-bold">{{$opened_tickets}}</span>--}}
{{--                            </div>--}}

{{--                            <div class="text-center">--}}
{{--                                <p class="card-text mb-50">Closed Tickets</p>--}}
{{--                                <span class="font-large-1 font-weight-bold">{{$closed_tickets}}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Support Tracker Chart Card ends -->
        </div>
        @endif
            @if((Gate::check('View Resources') || auth()->user()->hasAnyRole(['super admin']))&& \App\Models\Company::gettype()=="Main")

        <div class="row match-height">
            <div class="col-lg-6 col-12">
                <div class="row match-height">
                    <!-- Bar Chart - Orders -->
                    <div class="col-lg-6 col-md-3 col-6">
                        <div class="card">
                            <div class="card-body  ">
                                <h6>MEMORY</h6>
                                <h2 class="font-weight-bolder mb-1"> </h2>
                                <div class="font-weight-bolder text-danger" >
                                    <div class="progress progress-bar-info" style="height: 20px">
                                        <div
                                                class="progress-bar progress-bar-striped"
                                                id="memorybar"
                                                role="progressbar"
                                                aria-valuenow="20"
                                                aria-valuemin="20"
                                                aria-valuemax="100"
                                                style="width: 20%"
                                        ></div>
                                    </div>
                                </div>
{{--                                <div id="cpuchart2"></div>--}}
                            </div>
                        </div>
                    </div>
                    <!--/ Bar Chart - Orders -->

                    <!-- Line Chart - Profit -->
                    <div class="col-lg-6 col-md-3 col-6">
                        <div class="card card-tiny-line-stats">
                            <div class="card-body ">
                                <h6>Disk</h6>
                                <h2 class="font-weight-bolder mb-1"> </h2>
                                <div class="font-weight-bolder text-danger" >
                                    <div class="progress progress-bar-warning" style="height: 20px">
                                        <div
                                                class="progress-bar progress-bar-striped"
                                                id="diskbar"
                                                role="progressbar"
                                                aria-valuenow="20"
                                                aria-valuemin="20"
                                                aria-valuemax="100"
                                                style="width: 20%"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Line Chart - Profit -->

                    <!-- Earnings Card -->
                    <div class="col-lg-12 col-md-6 col-12">
                        <div class="card earnings-card">
                            <div class="card-body">
                                <h6>I/O wait</h6>
                                <h2 class="font-weight-bolder mb-1"> </h2>
                                <div class="font-weight-bolder text-danger">
                                    <div class="progress progress-bar-success" style="height: 20px">
                                        <div
                                                class="progress-bar progress-bar-striped"
                                                id="iobar"
                                                role="progressbar"
                                                aria-valuenow="20"
                                                aria-valuemin="20"
                                                aria-valuemax="100"
                                                style="width: 20%"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-12">
                        <div class="card earnings-card">
                            <div class="card-body">
                                <h6>CPU</h6>
                                <h2 class="font-weight-bolder mb-1"> </h2>
                                <div class="font-weight-bolder text-danger"  >
                                    <div class="progress progress-bar-primary" style="height: 20px">
                                        <div
                                                class="progress-bar progress-bar-striped"
                                                id="cpubar"
                                                role="progressbar"
                                                aria-valuenow="20"
                                                aria-valuemin="20"
                                                aria-valuemax="100"
                                                style="width: 20%"
                                        ></div>
                                    </div></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Earnings Card -->
                </div>
            </div>

            <!-- Revenue Report Card -->
            <div class="col-lg-6 col-12">
                <div class="card card-revenue-budget">
                    <div class="row mx-0">
                        <div class="col-md-12 col-12 revenue-report-wrappers">
                            <div class="d-sm-flex justify-content-between align-items-center  ">
                                <h4 class="card-title mb-50 mb-sm-0" style="padding-top: 10px">CPU Usage ( <span  id="cpu-usage"> </span> ) </h4>

                            </div>
                            <div id="cpu-chart"></div>
                            <div style="text-align: center" id="cpu-usages"> </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--/ Revenue Report Card -->
        </div>
        @endif
{{--        <div class="row match-height">--}}
{{--            <div class="col-lg-4 col-12">--}}
{{--                <div class="row match-height">--}}
{{--                    <!-- Bar Chart - Orders -->--}}
{{--                    <div class="   col-12">--}}
{{--                        <div class="card card-transaction">--}}
{{--                            <div class="card-header">--}}
{{--                                <h4 class="card-title">Customers</h4>--}}

{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="transaction-item">--}}
{{--                                    <div class="font-weight-bolder text-danger">Status</div>--}}
{{--                                    <div class="font-weight-bolder text-danger">Amount of Customers</div>--}}

{{--                                </div>--}}

{{--                                <div id="user_status_table">--}}

{{--                                </div>--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Revenue Report Card -->--}}
{{--            <div class="col-lg-8 col-12">--}}
{{--                <div class="card card-revenue-budget">--}}

{{--                    <div class="row mx-0">--}}
{{--                        <div class=" col-12 revenue-report-wrapper">--}}
{{--                            <div class="d-sm-flex justify-content-between align-items-center mb-3">--}}
{{--                                <h4 class="card-title mb-50 mb-sm-0">Resources Report</h4>--}}
{{--                                <div class="d-flex align-items-center">--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                              <div class="col-12">--}}
{{--                                  <div class="card card-transaction">--}}
{{--                                      <div class="card-header">--}}


{{--                                      </div>--}}
{{--                                      <div class="card-body">--}}

{{--                                          <div class="transaction-item">--}}
{{--                                              <div class="font-weight-bolder ">CPU usage</div>--}}
{{--                                              <div class="font-weight-bolder text-danger" style="width:50%">--}}
{{--                                                  <div class="progress progress-bar-primary">--}}
{{--                                                      <div--}}
{{--                                                              class="progress-bar progress-bar-striped"--}}
{{--                                                              id="cpubar"--}}
{{--                                                              role="progressbar"--}}
{{--                                                              aria-valuenow="20"--}}
{{--                                                              aria-valuemin="20"--}}
{{--                                                              aria-valuemax="100"--}}
{{--                                                              style="width: 20%"--}}
{{--                                                      ></div>--}}
{{--                                                  </div></div>--}}

{{--                                          </div>--}}
{{--                                          <hr>--}}
{{--                                          <div class="transaction-item">--}}
{{--                                              <div class="font-weight-bolder ">Memory</div>--}}
{{--                                              <div class="font-weight-bolder text-danger" style="width:50%">--}}
{{--                                                  <div class="progress progress-bar-info">--}}
{{--                                                      <div--}}
{{--                                                              class="progress-bar progress-bar-striped"--}}
{{--                                                              id="memorybar"--}}
{{--                                                              role="progressbar"--}}
{{--                                                              aria-valuenow="20"--}}
{{--                                                              aria-valuemin="20"--}}
{{--                                                              aria-valuemax="100"--}}
{{--                                                              style="width: 20%"--}}
{{--                                                      ></div>--}}
{{--                                                  </div>--}}
{{--                                              </div>--}}

{{--                                          </div>--}}
{{--                                          <hr>--}}
{{--                                          <div class="transaction-item">--}}
{{--                                              <div class="font-weight-bolder ">I/O Wait</div>--}}
{{--                                              <div class="font-weight-bolder text-danger" style="width:50%">--}}
{{--                                                  <div class="progress progress-bar-success">--}}
{{--                                                      <div--}}
{{--                                                              class="progress-bar progress-bar-striped"--}}
{{--                                                              id="iobar"--}}
{{--                                                              role="progressbar"--}}
{{--                                                              aria-valuenow="20"--}}
{{--                                                              aria-valuemin="20"--}}
{{--                                                              aria-valuemax="100"--}}
{{--                                                              style="width: 20%"--}}
{{--                                                      ></div>--}}
{{--                                                  </div>--}}
{{--                                              </div>--}}

{{--                                          </div>--}}
{{--                                          <hr>--}}
{{--                                          <div class="transaction-item">--}}
{{--                                              <div class="font-weight-bolder ">DISK</div>--}}
{{--                                              <div class="font-weight-bolder text-danger" style="width:50%">--}}
{{--                                                  <div class="progress progress-bar-warning">--}}
{{--                                                      <div--}}
{{--                                                              class="progress-bar progress-bar-striped"--}}
{{--                                                              id="diskbar"--}}
{{--                                                              role="progressbar"--}}
{{--                                                              aria-valuenow="20"--}}
{{--                                                              aria-valuemin="20"--}}
{{--                                                              aria-valuemax="100"--}}
{{--                                                              style="width: 20%"--}}
{{--                                                      ></div>--}}
{{--                                                  </div>--}}
{{--                                              </div>--}}

{{--                                          </div>--}}


{{--                                      </div>--}}
{{--                                  </div>--}}


{{--                                  </div>--}}



{{--                            </div>--}}
{{--                        </div>--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!--/ Revenue Report Card -->--}}
{{--        </div>--}}


{{--        <div class="row match-height">--}}
{{--            <!-- Company Table Card -->--}}
{{--            <div class="  col-6">--}}
{{--                <div class="card card-company-table">--}}
{{--                    <div class="card-body p-0">--}}
{{--                        <div class="card card-transaction">--}}
{{--                            <div class="card-header">--}}
{{--                                <h4 class="card-title">Leads</h4>--}}
{{--                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="transaction-item">--}}
{{--                                    <div class="font-weight-bolder text-danger">Status</div>--}}
{{--                                    <div class="font-weight-bolder text-danger">Amount</div>--}}
{{--                                    <div class="font-weight-bolder text-danger">Deal</div>--}}
{{--                                </div>--}}

{{--                                <div id="leads_status_table">--}}

{{--                                </div>--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="  col-6">--}}
{{--                <div class="card card-company-table">--}}
{{--                    <div class="card-body p-0">--}}
{{--                        <div class="card card-transaction">--}}
{{--                            <div class="card-header">--}}
{{--                                <h4 class="card-title">Finance</h4>--}}
{{--                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}


{{--                                <div id="leads_status_table">--}}
{{--                                    <ul class="list-group">--}}
{{--                                        <li class="list-group-item alert-success" style="text-align: center">Current Month</li>--}}
{{--                                        <li class="list-group-item">Debit transactions--}}
{{--                                            <span class="pull-right" id="admin_dashboard_panels_finance_current_debit" style=""> {{ $currentMonth->where('type', 'credit')->count() }} ({{ $currentMonth->where('type', 'credit')->sum('total') }} USD) </span>--}}
{{--                                        </li>--}}
{{--                                        <li class="list-group-item">Paid Invoices--}}
{{--                                            <span class="pull-right" id="admin_dashboard_panels_finance_current_payments" style="">{{ $currentMonthInvoices->where('status', '==', 'paid')->count() }} ({{ $currentMonthInvoices->where('status', '==', 'paid')->sum('total') }} USD)</span>--}}
{{--                                        </li>--}}

{{--                                        <li class="list-group-item">Unpaid Invoices--}}
{{--                                            <span class="pull-right" id="admin_dashboard_panels_finance_current_unpaid_invoices" style="">{{ $currentMonthInvoices->where('status', '==', 'unpaid')->count() }} ({{ $currentMonthInvoices->where('status', '==', 'unpaid')->sum('total') }} USD)</span>--}}
{{--                                        </li>--}}


{{--                                        <li class="list-group-item alert-warning" style="text-align: center">Last month</li>--}}
{{--                                        <li class="list-group-item">Debit transactions--}}
{{--                                            <span class="pull-right" id="admin_dashboard_panels_finance_current_debit" style=""> {{ $lastMonth->where('type', 'credit')->count() }} ({{ $lastMonth->where('type', 'credit')->sum('total') }} USD) </span>--}}
{{--                                        </li>--}}
{{--                                        <li class="list-group-item">Paid Invoices--}}
{{--                                            <span class="pull-right" id="admin_dashboard_panels_finance_current_payments" style="">{{ $lastMonthInvoices->where('status', '==', 'paid')->count() }} ({{ $lastMonthInvoices->where('status', '==', 'paid')->sum('total') }} USD)</span>--}}
{{--                                        </li>--}}

{{--                                        <li class="list-group-item">Unpaid Invoices--}}
{{--                                            <span class="pull-right" id="admin_dashboard_panels_finance_current_unpaid_invoices" style="">{{ $lastMonthInvoices->where('status', '==', 'unpaid')->count() }} ({{ $lastMonthInvoices->where('status', '==', 'unpaid')->sum('total') }} USD)</span>--}}
{{--                                        </li>--}}

{{--                                    </ul>--}}
{{--                                </div>--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </section>

    <!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('Plugins/amcharts/amcharts/amcharts.js')}}" type="text/javascript"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

    <script src="{{ asset('Plugins/amcharts/amcharts/serial.js')}}" type="text/javascript"></script>
    <script src="{{ asset('Plugins/amcharts/amcharts/themes/light.js')}}" type="text/javascript"></script>
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
{{--    <script src="{{ asset(mix('js/scripts/charts/chart-apex.js')) }}"></script>--}}



    <script src="{{ asset('Plugins/amcharts/amcharts/gauge.js') }}"></script>


@endsection
@section('page-script')
    {{-- Page js files --}}
    @if((Gate::check('View Dashboard') || auth()->user()->hasAnyRole(['super admin'])) )

    <script src="{{ asset('js/scripts/Dashboard/charts.js') }}"></script>
    @endif
    @if((Gate::check('View Resources') || auth()->user()->hasAnyRole(['super admin']))&& \App\Models\Company::gettype()=="Main")

    <script src="{{ asset('js/scripts/Dashboard/resources.js') }}"></script>
@endif


    <script>
        Echo.private('user.1').notification((notification) => {
                console.log(notification.message);
            });
        Echo.private('user.1').notification((notification) => {
            console.log(notification.message);
        });
        // Echo.private('App.Models.User.1').listen('')
        Echo.join('chat')
            .here((users) => {
               console.log(users);
            })
            .joining((user) => {

                // axios.put('/api/user/'+ user.id +'/online?api_token=' + user.api_token, {});
            });
    </script>
@endsection
