@extends('layouts/contentLayoutMaster')

@section('title', 'Users Group')

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
    @if(!Gate::check('Add Groups') && !auth()->user()->hasAnyRole(['super admin']))
        <style>
            #add_modal {
                display: none;
            }

        </style>
    @endif
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

                <table class="group-users-list-table table">

                    <thead class="thead-light">
                    <tr>
                        <th>  <div class="custom-control custom-checkbox">
                                <input class="form-check-input  " type="checkbox" id="checkall"    >

                            </div></th>

                        <th>GroupName</th>

                        <th>Customers</th>
                        <th>Description</th>
                        <th>Zone</th>

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

    <div class="modal modal-slide-in new-group-modal fade" id="modals-slide-in">
        <div class="modal-dialog" style=" ">

            <form class="add-new-group-form modal-content pt-0">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="group_id" id="group_id">
                                <label class="form-label" for="basic-icon-default-fullname">Group Name</label>
                                <input
                                        type="text"
                                        class="form-control "
                                        id="group_name"
                                        placeholder="Group Name"
                                        name="group_name"
                                        aria-label="Group Name"
                                        aria-describedby="basic-icon-default-fullname2"
                                />
                            </div>

                            <div class="form-group col-md-12">
                                <label class="form-label" for="basic-icon-default-fullname">Description</label>
                                <input
                                        type="text"
                                        class="form-control "
                                        id="description"
                                        placeholder="Description"
                                        name="group_name"
                                        aria-label="description"
                                        aria-describedby="basic-icon-default-fullname2"
                                />
                            </div>



                            <button type="submit" id="add_group_btn" status='add' class="btn btn-primary mr-1 data-submit">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                </div>
            </form>
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
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')

    <script src="{{ asset('js/scripts/Groups/script.js') }}"></script>

@endsection

