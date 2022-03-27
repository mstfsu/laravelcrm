@extends('layouts/contentLayoutMaster')

@section('title', 'View Group')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
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
            <input type="hidden" id="group_id" name="group_id" value="{{$id}}">
            <div class="card-datatable table-responsive pt-0">

                <table class="group-users-list-table table">

                    <thead class="thead-light">
                    <tr>
                        <th>  <div class="custom-control custom-checkbox">
                                <input class="form-check-input  " type="checkbox" id="checkall"    >

                            </div></th>

                        <th>Customer</th>
                        <th>email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>




            </div>
            <!-- Modal to add new user starts-->

            <!-- Modal to add new user Ends-->
        </div>



        <!-----change password modal ---->



        <!-- list section end -->


    </section>

    <!-------------------------------------Add Group Modal ---------------->





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
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')

    <script src="{{ asset('js/scripts/Groups/view.js') }}"></script>

@endsection

