
@extends('layouts/contentLayoutMaster')

@section('title', 'Import  Customers')

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
            <span class="bs-stepper-title">Upload xls File </span>
            <span class="bs-stepper-subtitle">Excel File</span>
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
            <span class="bs-stepper-title">MAP Data</span>
            <span class="bs-stepper-subtitle"> </span>
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
            <span class="bs-stepper-title">Import</span>
            <span class="bs-stepper-subtitle"> </span>
          </span>
                    </button>
                </div>

            </div>
            <div class="bs-stepper-content">
                <div id="account-details" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">Upload File </h5>

                    </div>
                    <form>
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-8">
                                <label>Upload File</label>
                                <div class="m-dropzone dropzone m-dropzone--success" enctype="multipart/form-data" action="/ISP/users/upload_import" id="m-dropzone-import">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h4 class="m-dropzone__msg-title"  >
                                            <span data-lang="drop_files_here_or_click_to_upload">Drag And Drop File Here To Upload</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display: flex;">
                                <label class="control-label col-md-12" style="margin:auto"><a  class="btn btn-success" href="/ISP/users/Download_import_example" data-lang=" "><i class="fa fa-cloud-download-alt"></i>Download Example</a></label>
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
                        <h5 class="mb-0">MAP Data</h5>
                        <small> </small>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form>




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


                    </div>


                </div>


                <div id="social-links" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">Documentation Proof</h5>
                        <small>Insert Documentation that required for Proof account.</small>
                    </div>
                    <form>


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

@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset( 'Plugins/countries/mobiscroll.jquery.min.js') }}"></script>
    <script src="{{ asset( 'js/scripts/Groups/import.js') }}"></script>




@endsection
