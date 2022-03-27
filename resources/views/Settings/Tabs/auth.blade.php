<div class="row">
    <form class="save_auth_settings modal-content pt-0">
        <div class="row">
            <div class="col-md-12">

                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Authentication Config </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Accept Expired/Blocked/New  Customers?</label>
                            </div>
                            <div class="col-sm-9">

                                <select id="accept_rejected_customers" name="accept_rejected_customers" class="form-control">
                                   <option value="1" @if(\App\Models\Settings::get('accept_rejected_customers')==1) selected @endif>YES</option>
                                    <option value="0"@if(\App\Models\Settings::get('accept_rejected_customers')==0) selected @endif>NO</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Accept Unknown  Customers?</label>
                            </div>
                            <div class="col-sm-9">

                                <select id="accept_rejected_customers" name="accept_rejected_customers" class="form-control">
                                    <option value="1" @if(\App\Models\Settings::get('accept_unknown_customers')==1) selected @endif>YES</option>
                                    <option value="0"@if(\App\Models\Settings::get('accept_unknown_customers')==0) selected @endif>NO</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Ignore Password?</label>
                            </div>
                            <div class="col-sm-9">

                                <select id="accept_rejected_customers" name="ignore_user_password" class="form-control">
                                    <option value="1" @if(\App\Models\Settings::get('ignore_user_password')==1) selected @endif>YES</option>
                                    <option value="0"@if(\App\Models\Settings::get('ignore_user_password')==0) selected @endif>NO</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Rejected  Customers Plan</label>
                            </div>
                            <div class="col-sm-9">

                                <select id="blocked_new_customers_plan" name="blocked_new_customers_plan" class="form-control">
                                    @foreach($plans as $profile)
                                        <option value="{{$profile->id}}" @if(\App\Models\Settings::get('blocked_new_customers_plan')==$profile->id) selected @endif>{{$profile->srvname}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Add User to Blocked Plan after Failed (Times)</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="add_user_to_blocked_plan_after" class="form-control" id="add_user_to_blocked_plan_after" value="{{\App\Models\Settings::get('add_user_to_blocked_plan_after')}}">
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="save_auth_btn" class="btn btn-primary mr-1 data-submit">Submit</button>

                </div>
            </div>
        </div>


    </form>
</div>
