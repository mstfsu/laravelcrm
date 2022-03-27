<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentMapInfo;
use App\Models\ClassificationGroup;
use App\Models\Company;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use un\unece\uncefact\data\specification\UnqualifiedDataTypesSchemaModule\_2\VideoType;
use Yajra\DataTables\DataTables;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Agents.index");
    }
    public function index_data()
    {
        $agents = Agent::query();
        return Datatables::of($agents)
            ->editColumn('actions', function ($data) {
                return view('Agents.actions', compact('data'));
            })
            ->editColumn('company', function ($data) {
                return $data->company->name;
            })
            ->editColumn('change_phone_request',function($data){
                return view('Agents.change-phone-request',compact('data'));
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('Create Agent')){
            return view("Agents.create");
        }else{
            return redirect()->back()->with('error', 'You are not authorized to perform this action');
        }



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
            "email" => 'required|unique:agents|',
            "password" => 'required|confirmed'
        ]);
        $request->merge([
            'password' => Hash::make($request->password),
        ]);
        Agent::create($request->except(["_token","password_confirmation"]));
        return view("Agents.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        return view('Agents.show',compact('agent'));
    }

    public function get_area(Request $request){
        $agent= Agent::find($request->id);
        $a = str_replace("(","",$agent->area);
        $a = str_replace(")","",$a);
        $array= explode(",",$a);
        return  array_chunk($array,2);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        return view("Agents.edit",compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agent $agent)
    {
        $validator= $request->validate([
            'email' => 'unique:agents,email,'.$agent->id,
            "password" => 'required|confirmed'
        ]);
        $request->merge([
            'password' => Hash::make($request->password),
        ]);
         $agent->update($request->except(['_token','_method','password_confirmation']));
         return redirect()->route('agents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index');
    }
    public function agent_work_hours($id){
        $agent=  Agent::where('id',$id)->first();
        $is_work_hours_added=false;
        if(!is_null($agent->work_hours)){
            $is_work_hours_added=true;
        }
        return view('Agents.agent-work-hours',compact("agent","is_work_hours_added"));
    }
    public function work_hours(Request $request){
        $agent=Agent::find($request->agent_id);
        $agent->update(['work_hours'=>$request->except(['_token','agent_id'])]);
        return redirect()->route('agents.index');
    }
    public function agent_classification(){
        $groups=ClassificationGroup::with("agents")->get();
        $agents=Agent::all();
        $levels=Level::all();
        return view("Agents.classification",compact("groups","levels","agents"));
    }
    public function delete_agent_from_group(Request $request){
        $group=ClassificationGroup::find($request->group_id);
        $group->agents()->detach($request->agent_id);
        return 'true';
    }
    public function classification_group_add_agent(Request $request){

        $group=ClassificationGroup::find($request->group_id);
        $exists = $group->agents->contains($request->agent_id);
        if($exists==1){
            return 'false';
        }else{
            $group->agents()->attach($request->agent_id, ['level_name' => $request->level_name]);
            return ['agent_id'=>$request->agent_id,'group_id'=>$request->group_id,"agent_name"=>Agent::find($request->agent_id)->name,'level_name'=>$request->level_name];
        }

    }
    public function add_classification_group(Request $request){
        if (ClassificationGroup::where("name",$request->group_name)->exists()) {
            return "false";
        }else{
            $group= ClassificationGroup::create(["name"=>$request->group_name]);
            return $group;
        }
    }
    public function change_agent_level(Request $request){
        $group=ClassificationGroup::find($request->group_id);
        $group->agents()->updateExistingPivot($request->agent_id, ['level_name' => $request->level]);
        return 'true';
    }
    public function track_agent(){
        return view("Agents.track-agent");
    }
    public function get_agent_info(Request $request){
        $agents = [];
        if ($request->has('q')) {
            $search = $request->q;
            $agents = Agent::where('name', 'LIKE', "%$search%")->get();

        }
        return response()->json($agents);
    }
    public function get_agent_map_infos(Request $request){
        
        $mapInfos = collect(AgentMapInfo::when($request->has('dateOption'), function ($query) use ($request) {
            if($request->has('dateType')){
                return $query->whereBetween('created_at', [now()->subHours($request->dateOption), now()]);
            }else{
                return $query->whereBetween('created_at', [now()->subDays($request->dateOption), now()]);  
            }
        })
        ->where('agent_id',$request->id)->get());
        return $mapInfos->unique(function ($item) {
            return $item['latitude'].$item['longitude'];
        })->values()->all();
    }
    public function remove_all(){
        Agent::truncate();
        AgentMapInfo::truncate();
        return response()->json([
            'success' => true,
            'message' => 'removed'
        ]);
    }
    public function approve_all_request(Request $request){

        try {
            Agent::where('change_phone_request',1)->update(['phone_unique_number'=>null,'change_phone_request'=>0]);
            return 'true';
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function approve_agent_request(Request $request){
        try {
            Agent::where([['change_phone_request',1],['id',$request->id]])->update(['phone_unique_number'=>null,'change_phone_request'=>0]);
            return 'true';
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
