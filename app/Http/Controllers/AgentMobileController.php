<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentMapInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Events\GetMapInfoEvent;
use App\Models\Task;

class AgentMobileController extends Controller
{
    
    public function generate_token(Request $request)
    {
        $agent=Agent::where('email', $request->email)->first();
        if($agent && Hash::check($request->password['value'], $agent->password))
        {
            try{
                $token = Str::random(60);
                $agent->forceFill([
                    'api_token' => hash('sha256', $token),
                ])->save();
                return response()->json([
                    'token' => $token,
                    'agent'=> $agent,
                    'success' => true,
                    'message' => "Token created successfully"
                ]);
            }
            catch(\Exception $e)
            {
                return response()->json(['message' => 'sorry error occured','success' => false]);
            }
          
        }
        else{
            return response()->json([
                'message' => "Token nott sent successfully",
                'success' => false,
            ]);
        }
        
    }
    public function create_map_info(Request $request){  
        try {
            $agentMapInfo= AgentMapInfo::where([['latitude', $request->latitude],['longitude', $request->longitude]])->whereBetween('created_at', [now()->subSeconds(30), now()])->first();
            if($agentMapInfo){
                return response()->json([
                    'message' => "same location added in 30 seconds",
                    'success' => true,
                ]);    
            }else{
                AgentMapInfo::create($request->except(['api_token']));
                event(new GetMapInfoEvent($request->except(['api_token'])));
                return response()->json([
                    'message' => "Added successfully",
                    'success' => true,
                ]); 
            }
            
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }    
    }
    public function get_agent_last_location(Request $request){
        $mapInfos = AgentMapInfo::select(['id','latitude','longitude'])->where('agent_id',$request->agent_id)->orderBy('id','desc')->first();
        if($mapInfos){
            return response()->json([
                'success' => true,
                'location' => $mapInfos,
                'message' => 'removed',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'no location found',
            ]);
        }
       
    }
    public function set_agent_phone_unique_number(Request $request){
        try {
            $controlIsNumberAdded= Agent::where("phone_unique_number",$request->phone_unique_number)->exists();
            if($controlIsNumberAdded){
                return response()->json([
                    'success' => false,
                    'message' => 'this phone already used by another agent',
                ]);
            }else{
                $agent = Agent::find($request->agent_id);
                $agent->update(['phone_unique_number'=>$request->phone_unique_number]);
                return response()->json([
                    'message' => "Phone unique number added successfully",
                    'agent'=> $agent,
                    'success'=>true,
                ]);
            }                       
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }
    }
    public function get_agent_phone_unique_number(Request $request){
        try {
            $agent = Agent::find($request->agent_id);
            return response()->json([
                'message' => "Phone unique number added successfully",
                'phone_unique_number'=> $agent->phone_unique_number,
                'success'=>true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }

    }
    public function change_phone_request(Request $request){
        try {
            $agent = Agent::find($request->agent_id);
            $agent->update(['change_phone_request'=>1]);
            return response()->json([
                'message' => "change phone unique request send",
                'agent'=> $agent,
                'success'=>true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }
    }
    public function get_task(Request $request){
        try {
            $agent = Agent::find($request->agent_id);
            return response()->json([
                'message' => "change phone unique request send",
                'tasks'=> $agent->tasks()->where('is_closed',0)->get(),
                'success'=>true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }
    }
    public function get_closed_task(Request $request){
        try {
            $agent = Agent::find($request->agent_id);
            return response()->json([
                'message' => "change phone unique request send",
                'tasks'=> $agent->tasks()->where('is_closed',1)->get(),
                'success'=>true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }
    }
    public function close_task(Request $request){
        try {
            $task = Task::find($request->task_id);
            $task->update(['is_closed'=>1]);
            return response()->json([
                'message' => "task closed",
                'success'=>true,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'success'=>false,
            ]);
        }
    }
}
