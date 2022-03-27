<div class="row">
    <form class="save_reseller_settings modal-content pt-0">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="setting_type" value="Reseller">
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Reseller Settings</h5>
                </div>
                <div class="modal-body flex-grow-1">

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Add Revenue to the Balance:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="add_revenue_balance" id="add_revenue_balance" class="form-control">
                                    <option value="1" @if(\App\Models\Settings::get('add_revenue_balance') ==1) selected @endif>Yes</option>
                                    <option value="0"  @if(\App\Models\Settings::get('add_revenue_balance') ==0) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Send Release Request:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="send_release_request" id="send_release_request" class="form-control">
                                    <option value="1" @if(\App\Models\Settings::get('send_release_request') ==1) selected @endif>Yes</option>
                                    <option value="0"  @if(\App\Models\Settings::get('send_release_request') ==0) selected @endif>No</option>
                                </select>                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Minimum Revenue for Release :</label>
                            </div>
                            <div class="col-sm-9">
                               <input type="number" class="form-control" id="min_revenue_release" name="min_revenue_release" value="{{\App\Models\Settings::get('min_revenue_release')}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Share Type:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="revenue_share_type_reseller" class="form-control">
                                    <option value="percent" @if(\App\Models\Settings::get('revenue_share_type_reseller') =='percent') selected @endif>Percent %</option>
                                    <option value="fixed" @if(\App\Models\Settings::get('revenue_share_type_reseller') =='fixed') selected @endif>Fixed</option>
                                    <option value="percent+fixed" @if(\App\Models\Settings::get('revenue_share_type_reseller') =='percent+fixed') selected @endif>Percent + Fixed</option>
                                </select>
                            </div>
                        </div>
                    </div>












                </div>




                <button type="submit" id="save_reseller_btn" class="btn btn-primary mr-1 data-submit">Submit</button>

            </div>
        </div>


    </form>
</div>
