<?php

namespace App\Http\Controllers;

use App\Models\Radacct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Redis;
use Cookie;
use Session;
use Auth;
use Log;
class LogsController extends Controller
{

public function index(){
    $session_id = Session::getId();
//    Redis::command('hmset', [
//        'PHPSESSID',
//        $session_id,
//        $session_id
//    ]);
    return view('Logs.index' );
}
public function  index_data(Request $request){
    $startdate=Carbon::parse($request->startdate);
    $starttime=$startdate->toTimeString();
    $finishdate=Carbon::parse($request->enddate);

    $finishtime=$finishdate->toTimeString();
    $ipaddress=$request->ipaddress;
    log::info($startdate. "startdate ". $starttime);
    log::info($finishdate." finishdate".$finishtime);

    $query = Radacct::whereNotNull('acctstoptime')->where(function($q) use($startdate,$finishdate,$starttime,$finishtime){
        return $q->where(function($q) use($startdate,$finishdate,$starttime,$finishtime){
            return $q->where('acctstarttime','>=',$startdate)->where('acctstarttime','<=',$finishdate);
        })->orwhere(function($q) use ($startdate,$finishdate,$starttime,$finishtime){
            return $q->where('acctstoptime','>=',$startdate)->where('acctstoptime','<=',$finishdate);
        });

    }) ;

 if(Auth::guard('customers')->check())
 {
     $username=Auth::guard('customers')->user()->username;
     $data = Radacct::query()->whereNotNull('acctstoptime')-> where('acctstarttime','>=',$startdate)->where('acctstarttime','<=',$finishdate)->where('username',$username)->withoutGlobalScope('company_id')->latest();;


 }
 if(isset($ipaddress)){
     $query=$query->where("framedipaddress",$ipaddress);
 }
 $data=$query->orderby('acctstarttime',"DESC");
    return Datatables::of($data)



        ->editColumn('username', function ($data) {

            $username = '<strong>'.$data->username.'</strong>';
            return $username;
        })
        ->editColumn('acctinputoctets', function ($data) {
            $download=$this->formatBytes($data->acctinputoctets);
            $download = '<strong>'.$download.'</strong>';
            return $download;
        })
        ->editColumn('acctoutputoctets', function ($data) {
            $upload=$this->formatBytes($data->acctoutputoctets);
            $upload = '<strong>'.$upload.'</strong>';
            return $upload;
        })



        ->rawColumns(['username','acctoutputoctets' ,'acctinputoctets'])


        ->make(true);


}
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
