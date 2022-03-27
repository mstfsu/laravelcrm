<div class="row">
    <form class="save_notification_settings modal-content pt-0">
        <div class="row">
            <div class="col-md-12">
           <input type="hidden" name="setting_type" value="notification">
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Notifications Settings</h5>
                </div>
                <div class="modal-body flex-grow-1">

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">New service plan activated:</label>
                            </div>
                            <div class="col-sm-9">
                              <select name="new_service_plan_activated" class="form-control">
                                  <option value="email" @if(\App\Models\Settings::get('new_service_plan_activated') =='email') selected @endif>Email</option>
                                  <option value="sms"  @if(\App\Models\Settings::get('new_service_plan_activated') =='sms') selected @endif>SMS</option>
                                  <option value="sms+email"  @if(\App\Models\Settings::get('new_service_plan_activated') =='sms+email') selected @endif>Email+SMS</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Welecom Message:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="welcome_message" class="form-control">
                                    <option value="email"  @if(\App\Models\Settings::get('welcome_message') =='email') selected @endif>Email</option>
                                    <option value="sms" @if(\App\Models\Settings::get('welcome_message') =='sms') selected @endif>SMS</option>
                                    <option value="sms+email" @if(\App\Models\Settings::get('welcome_message') =='sms+email') selected @endif>Email+SMS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Account Renew Notification:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="account_renew" class="form-control">
                                    <option value="email"  @if(\App\Models\Settings::get('account_renew') =='email') selected @endif>Email</option>
                                    <option value="sms"  @if(\App\Models\Settings::get('account_renew') =='sms') selected @endif>SMS</option>
                                    <option value="sms+email"  @if(\App\Models\Settings::get('account_renew') =='sms+email') selected @endif>Email+SMS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Account expiry alert:</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="account_expiry_alert" class="form-control">
                                    <option value="email" @if(\App\Models\Settings::get('account_expiry_alert') =='email') selected @endif>Email</option>
                                    <option value="sms" @if(\App\Models\Settings::get('account_expiry_alert') =='sms') selected @endif>SMS</option>
                                    <option value="sms+email" @if(\App\Models\Settings::get('account_expiry_alert') =='sms+email') selected @endif>Email+SMS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <div class="col-sm-3 col-form-label">
                            <label class="form-label decimal" for="basic-icon-default-email"> Welcome  SMS Template</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="welcome_sms_template" name="welcome_sms_template">
                                @foreach($sms_templates as $sms)
                                    <option value="{{$sms->id}}" @if(\App\Models\Settings::get('welcome_sms_template')==$sms->id) selected @endif>{{$sms->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-3 col-form-label">
                            <label class="form-label decimal" for="basic-icon-default-email"> Welcome Email Template</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="welcome_email_template" name="welcome_email_template">
                                @foreach($email_templates as $email)
                                    <option value="{{$email->id}}" @if(\App\Models\Settings::get('welcome_email_template')==$email->id) selected @endif  >{{$email->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group  row">
                        <div class="col-sm-3 col-form-label">
                            <label class="form-label decimal" for="basic-icon-default-email"> Expiry  SMS Template</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="sms_expiry_template" name="sms_expiry_template">
                                @foreach($sms_templates as $sms)
                                    <option value="{{$sms->id}}" @if(\App\Models\Settings::get('sms_expiry_template')==$sms->id) selected @endif>{{$sms->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-3 col-form-label">
                            <label class="form-label decimal" for="basic-icon-default-email"> Expiry Email Template</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="email_expiry_template" name="email_expiry_template">
                                @foreach($email_templates as $email)
                                    <option value="{{$email->id}}" @if(\App\Models\Settings::get('email_expiry_template')==$email->id) selected @endif  >{{$email->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-3 col-form-label">
                            <label class="form-label decimal" for="basic-icon-default-email"> Reminder Email Template</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="email_reminder_template" name="email_reminder_template">
                                @foreach($email_templates as $email)
                                    <option value="{{$email->id}}" @if(\App\Models\Settings::get('email_reminder_template')==$email->id) selected @endif  >{{$email->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="form-group  row">
                        <div class="col-sm-3 col-form-label">
                        <label class="form-label decimal" for="basic-icon-default-email"> Reminder SMS Template</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="sms_reminder_template" name="sms_reminder_template">
                                @foreach($sms_templates as $sms)
                                    <option value="{{$sms->id}}" @if(\App\Models\Settings::get('sms_reminder_template')==$sms->id) selected @endif>{{$sms->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Reminder #1 Day:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="reminder_day_1"  name="reminder_day_1" aria-invalid="false" value="{{\App\Models\Settings::get('reminder_day_1')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Reminder #2 Day:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="reminder_day_2"  name="reminder_day_2" aria-invalid="false" value="{{\App\Models\Settings::get('reminder_day_2')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Reminder #3 Day:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="reminder_day_3"  name="reminder_day_3" aria-invalid="false" value="{{\App\Models\Settings::get('reminder_day_3')}}">
                            </div>
                        </div>
                    </div>








                    </div>




                    <button type="submit" id="save_notification_btn" class="btn btn-primary mr-1 data-submit">Submit</button>

                </div>
            </div>


    </form>
</div>