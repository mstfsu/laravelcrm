<div class="row">
    <form class="save_general_settings modal-content pt-0">
        <div class="row">
            <div class="col-md-12">

                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">General Settings</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="basic-icon-default-fullname">Organization Name</label>
                        <input
                                type="text"
                                class="form-control "
                                id="organization_name"
                                placeholder="Company Name"
                                name="organization_name"
                                aria-label="organization_name"
                                value="{{\App\Models\Settings::get('organization_name')}}"

                                aria-describedby="basic-icon-default-fullname2"
                        />
                    </div>
                    <div class="form-group col-md-12 ">
                        <label class="form-label" for="basic-icon-default-email">Zone Name</label>
                        <div class="input-group  ">


                            <input type="text" class="form-control" id="zone_name" name="zone_name" placeholder="Zone Name" aria-label="zone"  value="{{\App\Models\Settings::get('zone_name')}}" />

                        </div>
                    </div>
                    <div class="form-group col-md-12">

                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-email">Email</label>
                            <div class="input-group mb-2">


                                <input type="text" class="form-control"  id="email" name="email" placeholder="Email" aria-label="email"   value="{{\App\Models\Settings::get('email')}}"/>

                            </div>
                        </div>
                        <div class="form-group  ">
                            <label class="form-label" for="basic-icon-default-email">Phone</label>
                            <div class="input-group mb-2">


                                <input type="text" class="form-control" id="phone" name="phone" placeholder="phone" aria-label="phone"  value="{{\App\Models\Settings::get('phone')}}" />

                            </div>
                        </div>
@if(\App\Models\Company::gettype()=="Main")
 <div class="form-group  ">
     <label class="form-label" for="basic-icon-default-email">Footer Text</label>
     <div class="input-group mb-2">


         <input type="text" class="form-control" id="footer_text" name="footer_text" placeholder="footer_text" aria-label="footer_text"  value="{{\App\Models\Settings::get('footer_text')}}" />

     </div>
 </div>
 @endif

 <div class="form-group  ">
     <label class="form-label decimal" for="basic-icon-default-email"> Import Email Template</label>
     <div class="input-group mb-2">
         <select class="form-control" id="email_import_template" name="email_import_template">
             @foreach($email_templates as $email)
                 <option value="{{$email->id}}" @if(\App\Models\Settings::get('email_import_template')==$email->id) selected @endif>{{$email->name}}</option>
             @endforeach
         </select>

     </div>
 </div>

 <div class="form-group  ">
     <label class="form-label decimal" for="basic-icon-default-email"> Import SMS Template</label>
     <div class="input-group mb-2">
         <select class="form-control" id="sms_import_template" name="sms_import_template">
             @foreach($sms_templates as $sms)
                 <option value="{{$sms->id}}" @if(\App\Models\Settings::get('sms_import_template')==$sms->id) selected @endif>{{$sms->name}}</option>
             @endforeach
         </select>

     </div>
 </div>
 <div class="form-group  ">
     <label class="form-label decimal" for="basic-icon-default-email">Default Import Plan(if not set)</label>
     <div class="input-group mb-2">
         <select class="form-control" id="default_import_plan" name="default_import_plan">
             @foreach($plans as $profile)
                 <option value="{{$profile->id}}" @if(\App\Models\Settings::get('default_import_plan')==$profile->id) selected @endif>{{$profile->srvname}}</option>
             @endforeach
         </select>

     </div>
 </div>
 <div class="form-group  ">
     <label class="form-label decimal" for="basic-icon-default-email">TimeZone</label>
     <div class="input-group mb-2">
         <select class="form-control" id="time_zone" name="time_zone">
             @foreach($timezone as $time)
                 <option value="{{$time['zone']}}"> ({{$time['GMT_difference']. ' ) '.$time['zone']}}</option>
             @endforeach
         </select>

     </div>
 </div>
 <div class="form-group  ">
 <div class="media-body mt-75 ml-1">
     <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload Logo</label>
     <input type="file" id="account-upload" hidden accept="image/*" />

     <p>Allowed JPG, GIF or PNG.  </p>
 </div>
     <img src="{{\App\Models\Settings::get('logo_image')}}" style="width: 10%;
border: 1px solid;
border-radius: 15px;"/>

 </div>





</div>




<button type="submit" id="save_general_btn" class="btn btn-primary mr-1 data-submit">Submit</button>

</div>
</div>

</div>
</form>
</div>