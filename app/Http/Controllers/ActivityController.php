<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NewActivity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
class ActivityController extends Controller
{
    public function admin(Request $request){
        $users=User::get();
    return view('Activity.admins',compact('users'));
}

  public function get_admin_activity(Request $request){

      $type=$request->type;
      $source=$request->source;
      $startdate=Carbon::parse($request->startdate);
      $finishdate=Carbon::parse($request->finishdate);


      if(!isset($source))
          $source=auth()->user()->id;

      $admin=User::find($source);


         $data = NewActivity::query()->withoutGlobalScope('company_id')->with('causer','subject')->CausedBy($admin)->whereDate('created_at',">=",$startdate)->whereDate("created_at","<=",$finishdate)->orderBy('created_at', 'DESC')->latest();
      return Datatables::of($data)
          ->addIndexColumn()




          ->addColumn('message', function ($data) {
              $result="";
           if(isset($data->subject->name))
               $result=$data->subject->name;
             elseif(isset($data->subject->username))
                 $result=$data->subject->username;

              $msgArray = array();
              $msg="";
              $data->diff=$data->created_at->diffForHumans() ;

              if (isset($data->properties['old'])) {


                  foreach ($data->properties['old'] as $key => $value) {
                      $oldkey = $key;
                      $oldval = $value;



                      foreach ($data->properties['attributes'] as $key => $value) {
                          if($key==$oldkey) {
                              $newval = $value;
                              $msg.= "<li>".$oldkey .  '  Changed from <code class="activity_code">'. $oldval .'</code>' .'to  <code class="activity_code">' . $newval . "</code></li>";

                          }

                      }



                  }


              } else {

                  $msg ="";
              }

              $data->msg=$msgArray;
              $causer="System";
              if(isset($data->causer->name))
                  $causer=$data->causer->name;

              $message= '<ul class="customers-activity-history-list" id="leads_activity_history_list_33">' .
                  '<li class="clearfix customer-activity-log-item" style="">' .
                  '    <div class="pull-left customer-activity-log-avatar">' .

                  '            </div>' .
                  '    <div class="pull-left customer-activity-log-message-text">' .
                  '        <span class="message-content"><b>'.$causer.'</b>  ' .$data->description.'</b>  '.$data->log_name.'   <b> #'.$data->subject_id ." ". $result.'</b>' .

                  '<ul>' .
                  $msg . '   ' .
                  '<div class="time">' .
                  '            <time class="text-muted timeago" datetime=" " title="2021-06-05 10:02:50">'.$data->diff.'</time>' .
                  '            <time class="text-muted"> ('.Carbon::parse($data->created_at)->format("Y-m-d H:i:s").')</time>' .
                  '        </div>'.
                  ' </ul></span></div></li></ul>';

              return $message;
          })
          ->addColumn('timestamp', function ($data) {

          })




          ->rawColumns(['message'])


          ->make(true);
  }
}
