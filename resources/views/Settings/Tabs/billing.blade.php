<div class="row">
    <form class="save_billing_settings modal-content pt-0">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="setting_type" value="billing">
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Billing/Payment </h5>
                </div>
                <div class="modal-body flex-grow-1">

                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Currency</label>
                            </div>
                            <div class="col-sm-9">

                                <select id="currency" name="currency" class="form-control">
                                    <option value="USD"  @if(\App\Models\Settings::get('currency')=='USD') selected @endif label="US dollar">USD</option>
                                    <option value="EUR" @if(\App\Models\Settings::get('currency')=='EUR') selected @endif label="Euro">EUR</option>
                                    <option value="INR" @if(\App\Models\Settings::get('currency')=='INR') selected @endif label="Indian rupee">INR</option>

                                </select>
                        </div>
                    </div>
                      </div>

                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">TAX %</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="tax_value" class="form-control" id="tax_value" value="{{\App\Models\Settings::get('tax_value')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Grace Period </label>
                            </div>
                            <div class="col-sm-9">
                                 <input type="number" name="grace_period" id="grace_period" class="form-control" value="{{\App\Models\Settings::get('grace_period')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Grace Times (Monthly) </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="grace_times_monthly" id="grace_times_monthly" class="form-control" value="{{\App\Models\Settings::get('grace_times_monthly')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Revert Period </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="revert_period" id="revert_period" class="form-control" value="{{\App\Models\Settings::get('revert_period')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Invoice Should Paid in (Days)</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="invoice_should_paid_in" id="invoice_should_paid_in" class="form-control" value="{{\App\Models\Settings::get('invoice_should_paid_in')}}">

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Disable Account due unpaid invoice</label>
                            </div>
                            <div class="col-sm-9">
<select name="disable_account_due_unpaid_invoice" id="disable_account_due_unpaid_invoice" class="form-control" >
    <option value="1"@if(\App\Models\Settings::get('disable_account_due_unpaid_invoice')==1) selected @endif>YES</option>
    <option value="0" @if(\App\Models\Settings::get('disable_account_due_unpaid_invoice')==0) selected @endif>NO</option>
</select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="expired_account_plan_div" style="display: none">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Expired Users Plan:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="expired_account_plan" id="expired_account_plan" class="form-control" >
                                    @foreach($plans as $plan)
                                        <option value="{{$plan->id}}" @if(\App\Models\Settings::get('expired_account_plan')==$plan->id) selected @endif>{{$plan->srvname}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Disable accounts due to expired contract </label>
                            </div>
                            <div class="col-sm-9">
                                <select name="disable_account_due_exoired_contract" id="disable_account_due_exoired_contract" class="form-control" >
                                    <option value="1"@if(\App\Models\Settings::get('disable_account_due_exoired_contract')==1) selected @endif>YES</option>
                                    <option value="0" @if(\App\Models\Settings::get('disable_account_due_exoired_contract')==0) selected @endif>NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Generate Invoice at</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="generate_invoice_at" name="generate_invoice_at" class="form-control flatpickr-time text-left" placeholder="HH:MM" value="{{\App\Models\Settings::get('generate_invoice_at')}}" />

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Invoice Prefix:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="invoice_prefix" name="invoice_prefix" class="form-control   text-left" placeholder="Prefix" value="{{\App\Models\Settings::get('invoice_prefix')}}" />

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row  ">
                            <div class="col-sm-3 col-form-label">
                                <label class="form-label" for="basic-icon-default-email">Invoice Template </label>
                            </div>
                            <div class="col-sm-9">
                                <select name="invoice_template" id="invoice_template" class="form-control" >
                                  @foreach($invoice_templates as $template)
                                    <option value="{{$template->id}}"@if(\App\Models\Settings::get('invoice_template')==$template->id) selected @endif>
                                        {{$template->name}}</option>
                                    @endforeach
                                 </select>
                            </div>
                        </div>
                    </div>
                <button type="submit" id="save_reseller_btn" class="btn btn-primary mr-1 data-submit">Submit</button>

            </div>
        </div>
        </div>


    </form>
</div>
