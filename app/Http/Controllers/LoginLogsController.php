<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LoginLogs;
use Yajra\DataTables\DataTables;

class LoginLogsController extends Controller
{
 public function get_login_logs_user(Request $request){
     
     $username=$request->username;
     $startdate=Carbon::parse($request->startdate);
     $finishdate=Carbon::parse($request->enddate);
     if(isset($username))
     $data=LoginLogs::query()->where('username',$username)->whereDate('created_at','>=',$startdate)->whereDate('created_at','<=',$finishdate)->latest();

     else
         $data=LoginLogs::query()-> whereDate('created_at','>=',$startdate)->whereDate('created_at','<=',$finishdate)->latest();

     return Datatables::of($data)



         ->editColumn('username', function ($data) {
             $contains = str_contains($data->result, 'Not Found');
             if(!$contains)
             $username = '<a href="/ISP/userview/'.$data->username.'"><strong>'.$data->username.'</strong></a>';
             else
                 $username = '<strong>'.$data->username.'</strong>';
             return $username;
         })
         ->addColumn('newreply', function ($data) {
             if( $data->reply== 'Reject')
                $reply="<div class='badge badge-danger' >$data->reply</div>";
             elseif( $data->reply== 'Accepted')
                 $reply="<div class='badge badge-success'>$data->reply</div>";
             elseif( $data->reply== 'offline')
                 $reply="<div class='badge badge-secondary'>$data->reply</div>";
             else
                 $reply="--";
             return $reply;
         })
         ->editColumn('created_at', function ($data) {

             return $data->created_at ;
         })
         ->editColumn('password', function ($data) {
             if($data->reply=='Accept')
                 return "----";
             else
                 return  $data->password;
         })

         ->rawColumns(['username','newreply','created_at' ])


         ->make(true);


 }
 public function index(Request $request){
     return  view('Logs.loginlogs');
 }
}
