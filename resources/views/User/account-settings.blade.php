@extends('layouts/contentLayoutMaster')

@section('title', 'Account Settings')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <!-- account setting page -->
    <input type="hidden" name="_token"  id="_token"content="{{csrf_token()}}">
    <section id="page-account-settings">
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <!-- general -->
                    <li class="nav-item">
                        <a
                                class="nav-link active"
                                id="account-pill-general"
                                data-toggle="pill"
                                href="#account-vertical-general"
                                aria-expanded="true"
                        >
                            <i data-feather="user" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">General</span>
                        </a>
                    </li>
                    <!-- change password -->
                    <li class="nav-item">
                        <a
                                class="nav-link"
                                id="account-pill-password"
                                data-toggle="pill"
                                href="#account-vertical-password"
                                aria-expanded="false"
                        >
                            <i data-feather="lock" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">Change Password</span>
                        </a>
                    </li>
                    <!-- information -->
{{--                    <li class="nav-item">--}}
{{--                        <a--}}
{{--                                class="nav-link"--}}
{{--                                id="account-pill-info"--}}
{{--                                data-toggle="pill"--}}
{{--                                href="#account-vertical-info"--}}
{{--                                aria-expanded="false"--}}
{{--                        >--}}
{{--                            <i data-feather="info" class="font-medium-3 mr-1"></i>--}}
{{--                            <span class="font-weight-bold">Information</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <!-- notification -->
                    <li class="nav-item">
                        <a
                                class="nav-link"
                                id="account-pill-notifications"
                                data-toggle="pill"
                                href="#account-vertical-notifications"
                                aria-expanded="false"
                        >
                            <i data-feather="bell" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">Notifications</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- general tab -->
                            <div
                                    role="tabpanel"
                                    class="tab-pane active"
                                    id="account-vertical-general"
                                    aria-labelledby="account-pill-general"
                                    aria-expanded="true"
                            >
                                <!-- header media -->
                                <div class="media">
                                    <a href="javascript:void(0);" class="mr-25">
                                        @if(Auth()->user()->profile->avatar!=null)
                                         <img

                                                src="{{Auth()->user()->profile->avatar}}"
                                                id="account-upload-img"
                                                class="rounded mr-50"
                                                alt="profile image"
                                                height="80"
                                                width="80"
                                        />
                                        @else
                                            <img

                                                    src="{{asset('images/portrait/small/avatar-s-11.jpg')}}"
                                                    id="account-upload-img"
                                                    class="rounded mr-50"
                                                    alt="profile image"
                                                    height="80"
                                                    width="80"
                                            />
                                            @endif
                                    </a>

                                    <!-- upload and reset button -->
                                    <div class="media-body mt-75 ml-1">
                                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                        <input type="file" id="account-upload" hidden accept="image/*" />
                                        <button class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                                        <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
                                    </div>
                                    <!--/ upload and reset button -->
                                </div>
                                <!--/ header media -->

                                <!-- form -->
                                <form class="general-form mt-2">
                                    <div class="row">

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-name">Name</label>
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        id="account-name"
                                                        name="name"
                                                        placeholder="Name"
                                                        value="{{Auth()->user()->name}}"

                                                />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-e-mail">E-mail</label>
                                                <input
                                                        type="email"
                                                        class="form-control"
                                                        id="account-e-mail"
                                                        name="email"
                                                        placeholder="Email"
                                                        value="{{Auth()->user()->email}}"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-phone">Phone</label>
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        id="account-phone"
                                                        placeholder="Phone number"
                                                        value="{{Auth()->user()->profile->mobile}}"
                                                        name="phone"
                                                />
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-2 mr-1">Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-2">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ general tab -->

                            <!-- change password -->
                            <div
                                    class="tab-pane fade"
                                    id="account-vertical-password"
                                    role="tabpanel"
                                    aria-labelledby="account-pill-password"
                                    aria-expanded="false"
                            >
                                <!-- form -->
                                <form class="password-form">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-old-password">Old Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input
                                                            type="password"
                                                            class="form-control"
                                                            id="account-old-password"
                                                            name="password"
                                                            placeholder="Old Password"
                                                    />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-new-password">New Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input
                                                            type="password"
                                                            id="account-new-password"
                                                            name="new-password"
                                                            class="form-control"
                                                            placeholder="New Password"
                                                    />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-retype-new-password">Retype New Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input
                                                            type="password"
                                                            class="form-control"
                                                            id="account-retype-new-password"
                                                            name="confirm-new-password"
                                                            placeholder="New Password"
                                                    />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mt-1">Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ change password -->

                            <!-- information -->
                            <div
                                    class="tab-pane fade"
                                    id="account-vertical-info"
                                    role="tabpanel"
                                    aria-labelledby="account-pill-info"
                                    aria-expanded="false"
                            >
                                <!-- form -->
                                <form class="validate-form">
                                    <div class="row">

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-birth-date">Birth date</label>
                                                <input
                                                        type="text"
                                                        class="form-control flatpickr"
                                                        placeholder="Birth date"
                                                        id="account-birth-date"
                                                        name="dob"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="accountSelect">Country</label>
                                                <select class="form-control" id="accountSelect">
                                                    <option>USA</option>
                                                    <option>India</option>
                                                    <option>Canada</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-phone">Phone</label>
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        id="account-phone"
                                                        placeholder="Phone number"
                                                        value="(+656) 254 2568"
                                                        name="phone"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-1 mr-1">Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ information -->

                            <!-- social -->


                            <!-- notifications -->
                            <div
                                    class="tab-pane fade"
                                    id="account-vertical-notifications"
                                    role="tabpanel"
                                    aria-labelledby="account-pill-notifications"
                                    aria-expanded="false"
                            >
                                <div class="row">
                                    <h6 class="section-label mx-1 mb-2">Activity</h6>
                                    <div class="col-12 mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" checked id="accountSwitch1" />
                                            <label class="custom-control-label" for="accountSwitch1">
                                                Email me when New Router Added
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" checked id="accountSwitch2" />
                                            <label class="custom-control-label" for="accountSwitch2">
                                                Email me when Router disconnected
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="accountSwitch3" />
                                            <label class="custom-control-label" for="accountSwitch3">Email me when new lead has been created</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="accountSwitch4" />
                                            <label class="custom-control-label" for="accountSwitch4">Email me when Won a Lead</label>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mt-2 mr-1">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-2">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ notifications -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
    <!-- / account setting page -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    {{-- select2 min js --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    {{--  jQuery Validation JS --}}
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset('js/scripts/User/account-settings.js') }}"></script>
@endsection
