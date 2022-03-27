<?php

namespace App\Http\Controllers;

use App\Models\ClassificationGroup;
use App\Models\Level;
use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Userprofile;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image as Image;
use Stancl\Tenancy\Features\UserImpersonation;
use Storage;
use Illuminate\Support\Str;
use Session;
use Yajra\DataTables\DataTables;
use Auth;
use Log;
use Closure;
use Redirect;
class UserController extends Controller
{


    public function user_settings(Request $request){

        return view('User.account-settings');
    }
    public function changegeneral(Request  $request){
        $id=auth()->user()->id;
        $user=User::find($id);
        $userprofile=Userprofile::firstOrCreate(['user_id'=>$id ]);
        $user->email=$request->email;
        $user->name=$request->name;
        $res=$user->save();
        if($res){
            if( Session::get('Avatar_Image'))
            {$userprofile->avatar = Session::get('Avatar_Image');
                Session::forget('Avatar_Image');
            }
            $userprofile->email=$request->email;
            $userprofile->name=$request->name;
            $userprofile->mobile=$request->phone;
            $userprofile->save();

         echo json_encode(['success'=>"true","msg"=>"User has been saved successfully"]);

        }
        else{
            echo json_encode(['success'=>"false","msg"=>"Error ! Please try again Later !"]);
        }

    }
    public function changePassword(Request  $request){
           $id=auth()->user()->id;
           $newpassword=$request->newpassword;
           $user=User::find($id);
           $user = User::findOrFail($id);
           $user->password= Hash::make($newpassword);
           $res=$user->save();
           if($res){
              echo json_encode(['success'=>"true","msg"=>"Password Changed successfully"]);

            }
           else{
            echo json_encode(['success'=>"false","msg"=>"Error ! Please try again Later !"]);
            }
         }

    public function checkpassword(Request  $request)
    {
        $id = auth()->user()->id;
        $oldpassword = $request->password;
          $user = User::find($id);

        if (Hash::check($oldpassword, auth()->user()->password)) {
            echo 'true';
        }
        else{
            echo json_encode("old password is not correct! ");
        }
    }
    public function checkemail(Request  $request)
    {
        $id = auth()->user()->id;
        $email = $request->email;
        $emailcount = User::where('email',$email)->where('id','!=',$id)->count();

        if ($email>0) {
            echo json_encode("this Email is already token ! ");

        }
        else{
            echo 'true';
        }
    }

    public function uploadIdImage(Request $request){



    }
    public function Upload_avatar(Request $request){
        $file = $request->file('file');
        $filename = "avatar".time().'.'.$file->extension();
        $img = Image::make($file->getRealPath());
        $img->stream();
        if(Auth::guard('customers')->check()) {
            Storage::disk('public')->put('upload/Customers/Avatar/' . $filename, $img);
            $path= '/storage/upload/Customers/Avatar/'.$filename;
            Session::put('Customer_Avatar_Image', $path);
        }

        else {
            Storage::disk('public')->put('upload/Admins/Avatar/' . $filename, $img);
            $path = '/storage/upload/Admins/Avatar/' . $filename;
            Session::put('Avatar_Image', $path);
        }


        return response()->json(['success'=>$filename]);

    }

    public  function index(){
        return  view('User.index');
    }


public function admin_list(Request  $request){
    $session =Session::get('tenant_impersonation');
    if(isset($session))
        $tenant=$session;
    else
        $tenant = $request->user()->company_id;
   
    $data=User::query()->with('company');


    return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($data)  {

return view('Actions.admin_actions',compact('data'));

        })


        ->editColumn('name', function ($data) {
             return "<strong>".$data->name."</strong>";
        })
        ->addColumn('role', function ($data) {
            return view('User.Includes.roles', compact(  'data'));



        })
        ->addColumn('company', function ($data) {
          if(isset($data->company->name))
              return $data->company->name;
          else
              return "";



        })
        ->editColumn('created_at', function ($data) {
           return  Carbon::parse($data->created_at)->format('Y-m-d');



        })

        ->rawColumns([ 'role','name' ])


        ->make(true);
}


public  function add(Request $request){
        $users=User::get();
        $roles=Role::get();
        $companies=Company::get();
     return view('User.add',compact('users','roles','companies'));
}
    public  function edit(Request $request){
        $id=$request->id;
        $details=User::with('profile')->findorfail($id);
        $userRoles = $details->roles->first();
        $users=User::get();
        $roles=Role::get();
        $companies=Company::get();
         return view('User.edit',compact('users','roles','details','userRoles','companies'));
    }

public function email_exists(Request $request){

        $email=$request->email;
        $user_email=$request->user_email;
    $count=User::withoutGlobalScope('company_id')->where('email',$email)->orwhere('email',$user_email)->count();
    if($count>0){
        echo json_encode("Email is Already Taken");
    }
    else{
        echo 'true';
    }
}
public function addadmin(Request $request){

    $session =Session::get('tenant_impersonation');
    if(isset($session))
        $tenant=$session;
    else
        $tenant = $request->user()->company_id;
    if(isset($request->company))
        $zone_id=$request->company;
    else
        $zone_id=$tenant;

 $email=$request->email;
 $phone=$request->phone;
 $role=$request->role;
 $name=$request->full_name;

 $pincode=$request->pincode;
 $country=$request->country;
 $city=$request->city;
 $state=$request->state;
 $lattitude=$request->latitude;
 $longitude=$request->longitude;
 $address=$request->address;
 $password=$request->password;
 $user=new User();
 $user->name=$name;
 $user->email=$request->email;
 $user->password=Hash::make($password);
 $user->company_id=$zone_id;
$res= $user->save();
if($res) {
    $user->syncRoles($role);
    $user->Zone()->sync($zone_id);
    $userprofile = Userprofile::firstOrCreate(['user_id' => $user->id], $user->toArray());
    $userprofile->mobile = $phone;
    $userprofile->email = $email;
    $userprofile->pincode = $pincode;
    $userprofile->country = $country;
    $userprofile->state = $state;
    $userprofile->latitude = $lattitude;
    $userprofile->longitude = $longitude;
    $userprofile->address = $address;
    $userprofile->city = $city;

    if (Session::get('Avatar_Image')) {
        $userprofile->avatar = Session::get('Avatar_Image');
        Session::forget('Avatar_Image');
    }
    $userprofile->save();
    echo json_encode(['success'=>"true","msg"=>"Admin has been Added successfully"]);
}
else{
    echo json_encode(['success'=>"false","msg"=>"Error! Please Try again later"]);
}

}

public function editadmin (Request $request){
    $session =Session::get('tenant_impersonation');
    if(isset($session))
        $tenant=$session;
    else
        $tenant = $request->user()->company_id;
    if(isset($request->company))
        $zone_id=$request->company;
    else
        $zone_id=$tenant;
    $email=$request->email;
    $phone=$request->phone;
    $role=$request->role;
    $name=$request->full_name;
    $owner=$request->owner;
    $pincode=$request->pincode;
    $country=$request->country;
    $city=$request->city;
    $state=$request->state;
    $lattitude=$request->latitude;
    $longitude=$request->longitude;
    $address=$request->address;
    $password=$request->address;
    $id=$request->id;
    $user=User::findorfail($id);
    $user->name=$name;
    $user->email=$request->email;
    $user->company_id=$zone_id;
    $res= $user->save();
    if($res) {
        $user->syncRoles($role);
        $userprofile = Userprofile::firstOrCreate(['user_id' => $id], $user->toArray());
        $userprofile->mobile = $phone;
        $userprofile->email = $email;
        $userprofile->pincode = $pincode;
        $userprofile->country = $country;
        $userprofile->state = $state;
        $userprofile->latitude = $lattitude;
        $userprofile->longitude = $longitude;
        $userprofile->address = $address;
        $userprofile->city = $city;

        if (Session::get('Avatar_Image')) {
            $userprofile->avatar = Session::get('Avatar_Image');
            Session::forget('Avatar_Image');
        }
        $userprofile->save();
        echo json_encode(['success'=>"true","msg"=>"Admin has been Saved successfully"]);
    }
    else{
        echo json_encode(['success'=>"false","msg"=>"Error! Please Try again later"]);
    }


}
    public function changeAdminPassword(Request  $request){

        $id=$request->id;
        $newpassword=$request->password;

        $user = User::findOrFail($id);
        $user->password= Hash::make($newpassword);
        $res=$user->save();
        if($res){
            echo json_encode(['success'=>"true","msg"=>"Password Changed successfully"]);

        }
        else{
            echo json_encode(['success'=>"false","msg"=>"Error ! Please try again Later !"]);
        }
    }
    public function delete(Request $request){
        $id=$request->id;
          $admin=User::withCount('ispusers')->withCount('devices')->findorfail($id);
          if($admin->ispusers_count>0 || $admin->devices_count>0){
              echo json_encode(['success'=>"false","msg"=>"Error !  you can not delete it now "]);
          }
          else{
              $admin->profile()->delete();
             $res= $admin->delete();
              if($res){
                  echo json_encode(['success'=>"true","msg"=>"Deleted successfully"]);

              }
              else{
                  echo json_encode(['success'=>"false","msg"=>"Error ! Please try again Later !"]);
              }
          }
    //

  //
    }
    public function admin_classification(){
        $session = Session::get('tenant_impersonation');
        $tenant = 1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        $groups=ClassificationGroup::with("admins")->get();
        $users=User::where('company_id',$tenant)->get();
        $levels=Level::all();
        return view("User.admin-classification-index",compact("groups","levels","users"));
    }
    public function classification_group_add_admin(Request $request){

        $group=ClassificationGroup::find($request->group_id);
        $exists = $group->admins->contains($request->admin_id);
        if($exists==1){
            return 'false';
        }else{
            $group->admins()->attach($request->admin_id, ['level_name' => $request->level_name]);
            return ['admin_id'=>$request->admin_id,'group_id'=>$request->group_id,"admin_name"=>User::find($request->admin_id)->name,'level_name'=>$request->level_name];
        }

    }
    public function delete_admin_from_group(Request $request){
        $group=ClassificationGroup::find($request->group_id);
        $group->admins()->detach($request->admin_id);
        return 'true';
    }
    public function add_classification_group(Request $request){
        if (ClassificationGroup::where("name",$request->group_name)->exists()) {
            return "false";
        }else{
            $group= ClassificationGroup::create(["name"=>$request->group_name]);
            return $group;
        }
    }
    public function change_admin_level(Request $request){
        $group=ClassificationGroup::find($request->group_id);
        $group->admins()->updateExistingPivot($request->admin_id, ['level_name' => $request->level]);
        return 'true';
    }
    public  function switch_account(Request $request ){
        $id=$request->id;
//        $type=$request->type;
//
//        $arr = explode("root", $string, 2);
//        $id=$arr[0];
        $user=Company::withoutGlobalScope('company_id')->find($id);
       
       
            Session::put('tenant_impersonation',$id);


        return Redirect::back();
     }
    public function leave_switch(){
        Auth::user()->leaveImpersonation();
        return redirect('/');
    }



    public  function changestatus(Request $request){
        $id=$request->id;
        $user=auth()->user();
        $user->status_id=$id;
        $user->save();
        $class="avatar-status-".$user->onlinestatus->status;

        echo json_encode(['status'=>$user->onlinestatus->name,"class"=>$class]);

    }
    public function delete_group(Request $request){
        try {

            $group=ClassificationGroup::find($request->groupId);
            if($group->tickets->isNotEmpty()){
                return 'Some tickets has this group. Before delete group you should delete tickets.';
            }else{
                $group->delete();
                DB::table('admin_groups')->where('classification_group_id',$request->groupId)->delete();
                return 'true';
            }

        }catch (\Exception $e){
            return $e;
        }
    }
    public function change_assign_ticket(Request $request){
        try {
            ClassificationGroup::find($request->groupId)->update(['assign_ticket'=>$request->value]);
        } catch (\Exception $e){
            return $e;
        }
    }
    public function admin_work_hours($id){
        $user =  User::where('id',$id)->first();
        $is_work_hours_added=false;
        if(!is_null($user->work_hours)){
            $is_work_hours_added=true;
        }
        return view('User.admin-work-hours',compact("user","is_work_hours_added"));
    }
    public function work_hours(Request $request){
        $user=User::find($request->user_id);
        $user->update(['work_hours'=>$request->except(['_token','user_id'])]);
        return redirect()->route('Admin-list');
    }

 

}

