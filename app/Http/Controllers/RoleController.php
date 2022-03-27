<?php

namespace App\Http\Controllers;

use App\Models\AuthTest;
use App\Models\PermissionTree;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function  index(){
     //   $user=User::find(1);
   //     event(new \App\Events\ActivityEvent('login', $user));
        return view('Roles.index');


    }
    public function  addrole(){

        return view('Roles.add');


    }

    public function roles_list(Request  $request){
         $data=Role::get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data)  {


                return  view('Actions.roles_actions',compact('data'));
            })


            ->editColumn('name', function ($data) {

                return  '<strong>'.$data->name.'</strong>';
            })


            ->rawColumns([ 'name' ])


            ->make(true);

    }
    public function permissions_tree(Request  $request){
        $roots=PermissionTree::with('permissions')->get();
        $data2 = [];
        foreach ($roots as $root){
         $root->text=$root->name;
            $data2[] = [
                'id' => $root->id."root",
                'parent'=>'#',
                'text' => $root->name,


            ];

         foreach ($root->permissions as $child){
             $data2[] = [
                 'id' => $child->id,
                 'parent'=>$root->id."root",
                 'text' => $child->name,


             ];
         }

        }
        return  $data2;



    }
    public function permissions_tree_edit(Request  $request){
        $id=$request->id;
        $roles=Role::with('permissions')->findorfail($id);
        $role=$roles->permissions()->pluck('id')->toArray();
        $roots=PermissionTree::with('permissions')->get();
        $data2 = [];
        foreach ($roots as $root){
            $root->text=$root->name;
            $data2[] = [
                'id' => $root->id."root",
                'parent'=>'#',
                'text' => $root->name,


            ];

            foreach ($root->permissions as $child){
                $state =false;
                if(in_array($child->id,$role))
                    $state=true;
                $data2[] = [
                    'id' => $child->id,
                    'parent'=>$root->id."root",
                    'text' => $child->name,
                    "state"=>['checked'=>$state,"selected"=>$state,"opened"=>$state]


                ];
            }

        }
        return  $data2;



    }

    public function  add(Request $request){
        $role_name=$request->role_name;
        $permissions=$request->selectedElmsIds;
        $role=new Role();
        $role->name=$role_name;
        $role->guard_name='web';
        $res=$role->save();
        $array=[];
        foreach ($permissions as $permission)
        {
            if(!str_contains($permission,'root')){
               array_push($array,$permission);
            }
        }
        if($res){
            if (isset($permissions)) {
                $role->syncPermissions($array);
            } else {
                $permissions = [];
                $role->syncPermissions($permissions);
            }
            echo   json_encode(['success' => 'true','msg'=>"New Role Saved Successfully  ",'IsSuccessful'=>'true' ]);
        } else {
            echo   json_encode(['success' => 'false','msg'=>"!Error",'IsSuccessful'=>'false' ]);
        }

    }
    public function  update(Request  $request){
        $id=$request->id;
        $role_name=$request->role_name;
        $permissions=$request->selectedElmsIds;
        $role=Role::findorfail($id);
        $role->name=$role_name;

        $res=$role->save();
        $array=[];
        foreach ($permissions as $permission)
        {
            if(!str_contains($permission,'root')){
                array_push($array,$permission);
            }
        }
        if($res){
            if (isset($permissions)) {
                $role->syncPermissions($array);
            } else {
                $permissions = [];
                $role->syncPermissions($permissions);
            }
            echo   json_encode(['success' => 'true','msg'=>"  Role Saved Successfully  ",'IsSuccessful'=>'true' ]);
        } else {
            echo   json_encode(['success' => 'false','msg'=>"!Error",'IsSuccessful'=>'false' ]);
        }
    }
    public function  edit(Request  $request){
        $role_id=$request->id;
        $role=Role::findorfail($role_id);
        $role_name=$role->name;
return view ('Roles.edit',compact('role_id','role_name'));
    }
    public function delete(Request $request){
        $id=$request->id;
        $user_roles = Auth::user();
        $role= Role::findOrFail($id);
        if($id==1){
            echo   json_encode(['success' => 'false','msg'=>"!Error You can not delete super admin role",'IsSuccessful'=>'false' ]);
        }
        elseif (in_array($id, $user_roles->toArray())) {
            echo   json_encode(['success' => 'false','msg'=>"!Error You can not delete your  role",'IsSuccessful'=>'false' ]);
        }

        try {
            if ($role->delete()) {
                echo   json_encode(['success' => 'true','msg'=>"Role has been deleted successfully",'IsSuccessful'=>'true' ]);
            }
        } catch (\Exception $e) {

            echo   json_encode(['success' => 'false','msg'=>"Error ! Can not delete this role at the moment please try again later",'IsSuccessful'=>'false' ]);
        }
    }


    public function testLdap(){
        $test=new AuthTest();
        $test->test_ldap_authentication_works();
    }
 public function kubulay(){


       $json =  file_get_contents('https://burakfidanci.com.tr/categories.json');

   $json = json_decode(   $json) ;
     //$json=(object) $json;
     foreach($json as $category){
         if($category->parent_id==0) {
             $data2[] = [
                 'id' => $category->id . "root",
                 'parent' => '#',
                 'text' => $category->category_name,


             ];
         }
         else{

             $data2[] = [
                 'id' => $category->id. "root" ,
                 'parent' =>$category->parent_id. "root",
                 'text' => $category->category_name,


             ];
         }

     }

return $data2;
 }
 public function kubulay_page(){
        return view('Roles.kubulay');
 }
}
