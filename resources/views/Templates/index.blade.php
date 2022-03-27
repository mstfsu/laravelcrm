@extends('layouts/contentLayoutMaster')

@section('title', 'Templates List')

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

                <table class="template-list-table table">

                    <thead class="thead-light">
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Description </th>


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
                                    <h5 class="modal-title" id="exampleModalLabel">New Router</h5>
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

                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach


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

    <script src="{{ asset('js/scripts/Templates/script.js') }}"></script>


@endsection
