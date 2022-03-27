<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use App\Models\Profile;
use App\Models\Settings;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Storage;
use Illuminate\Support\Str;
use Session;
use Config;
use DateTime;
use App\Models\Invoicetemplates;
class SettingsController extends Controller
{
  public function index(){
      $session =Session::get('tenant_impersonation');
      if(isset($session))
          $tenant=$session;
      else
          $tenant = auth()->user()->company_id;
      $email_templates=MessageTemplate::where('type','email')->where('partner_id',request()->user()->id)->get();
      $sms_templates=MessageTemplate::where('type','sms')->where('partner_id',request()->user()->id)->get();
    //  $plans=Profile::get();
      if($tenant==1)
          $plans=Profile::get();
      else
      $plans = Profile::withoutGlobalScope('company_id')->where('company_id',$tenant)->orwhereHas('allocated_to',function ($q) use ($tenant){
          return $q->where('reseller_id',$tenant);
      })->get();
      $timezone = array();
      $timestamp = time();
      $invoice_templates=Invoicetemplates::get();
      foreach(timezone_identifiers_list(\DateTimeZone::ALL) as $key => $t) {
          date_default_timezone_set($t);
          $timezone[$key]['zone'] = $t;
          $timezone[$key]['GMT_difference'] =  date('P', $timestamp);
      }
      $timezone = collect($timezone)->sortBy('GMT_difference');
       return view('Settings.index',compact('sms_templates','email_templates','plans','timezone','invoice_templates'));
  }
  public function Upload_logo(Request $request){

          $file = $request->file('file');
          $filename = "logo".time().'.'.$file->extension();
          $img = Image::make($file->getRealPath());
          $img->stream();
          Storage::disk('public')->put('upload/Admins/Settings/'.request()->user()->id.'/'.$filename, $img);
          // $file->move($location, $filename);
          $path= '/storage/upload/Admins/Settings/'.request()->user()->id.'/'.$filename;
          Session::put('Logo_Image', $path);

          return response()->json(['success'=>$filename]);

      }
      public function save_general(Request $request){

          $zone_id=auth()->user()->company_id;
          $session =Session::get('tenant_impersonation');
          if(isset($session))
              $tenant=$session;
          else
              $tenant = $request->user()->company_id;
      $inputs=$request->all();
      $logo=Session('Logo_Image');
      if(isset($logo)) {
          $settings = Settings::updateOrCreate([ 'company_id' => $tenant, 'module' => 'Settings', 'name' => "logo_image"], ['val' => $logo, 'type' => 'text']);
          $settings->company_id = $tenant;
          $settings->save();
      }
      foreach ($inputs as $key=>$value) {
          $settings = Settings::updateOrCreate([ 'company_id'=>$tenant,'module' => 'Settings', 'name' => "$key" ],['val'=>$value,'type'=>'text' ]);
          $settings->company_id=$tenant;
          $settings->save();
          if($key=="time_zone") {
              $now = new DateTime();
              $tz = $now->getTimezone();
            // echo  $tz = $tz->getName();
             
              Config::set('app.timezone', $value);
          }
      }
          echo json_encode(['success' => "true", "msg" => "Saved successfully"]);


      }
public function save_notification(Request $request){
    $session =Session::get('tenant_impersonation');
    if(isset($session))
        $tenant=$session;
    else
        $tenant = $request->user()->company_id;
    $inputs=$request->all();

    $zone_id=$tenant;
    $inputs=$request->except('setting_type');


    foreach ($inputs as $key=>$value) {

        $settings = Settings::updateOrCreate(['company_id'=>$tenant, 'module' => 'Settings', 'name' => "$key" ],['val'=>$value,'type'=>'text' ]);
        $settings->company_id=$tenant;
        $settings->setting_type=$request->setting_type;
        $settings->save();

    }
    echo json_encode(['success' => "true", "msg" => "Saved successfully"]);

}

}
