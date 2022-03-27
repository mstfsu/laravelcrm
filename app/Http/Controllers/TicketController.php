<?php

namespace App\Http\Controllers;

use App\Events\GetMapInfoEvent;
use App\Events\PrivateMessageEvent;
use App\Models\Agent;
use App\Models\ClassificationGroup;
use App\Models\Level;
use App\Models\Priority;
use App\Models\Settings;
use App\Models\Status;
use App\Models\Subject;
use App\Models\Subscriber;
use App\Models\Task;
use App\Models\TaskType;
use App\Models\Ticket;
use App\Models\TicketMessages;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Modules\Gallery\Entities\Gallery;
use Yajra\DataTables\DataTables;
use Session;
use Log;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = Type::with('subjects')->get()->toArray();
        $adminViewAllTickets = json_decode(Settings::get('admin_view_all_tickets',"[]"));
        $adminViewAllUnassignedTickets = json_decode(Settings::get('admin_view_unassigned_tickets'));
        $automaticAdminAssignWay = Settings::get('automatic_admin_assign_way');
        $adminViewUnassignedTickets = json_decode(Settings::get('admin_view_unassigned_tickets',"[]"));
        $canSeeUnassigned = 0;
        $isSuperAdmin = auth()->user()->hasAnyRole(['super admin']);
        if ($this->is_admin_in_this_group(Auth::user()->classification_groups, $adminViewUnassignedTickets) || $this->is_admin_in_this_group(Auth::user()->classification_groups, $adminViewAllTickets) || $isSuperAdmin) {
            $canSeeUnassigned = 1;
        }
        return view("Tickets.index", compact("automaticAdminAssignWay", "priorities", "types", "status", 'adminViewAllTickets', 'adminViewAllUnassignedTickets', 'canSeeUnassigned'));
    }

    public function index_data(Request $request)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = Type::with('subjects')->get()->toArray();
        $tickets = [];
        $adminCanViewOnlyTicketsAssigned = Settings::get('admin_can_view_only_tickets_assigned',"");
        $adminViewAllTickets = Settings::get('admin_view_all_tickets',"[]");
        $status_id=Status::where('name','=',"New")->first()->id;
        $isAdminInAllViewList = $adminCanViewOnlyTicketsAssigned == "checked" && $this->is_admin_in_this_group(Auth::user()->classification_groups, json_decode($adminViewAllTickets));
        $isSuperAdmin = auth()->user()->hasAnyRole(['super admin']);
        if ($isAdminInAllViewList || $isSuperAdmin) {
            $tickets = Ticket::query()->where('is_closed', "=", 0)->where('status_id', "=", $status_id)->with("customer:id,username", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "assigned_user:id,name", "group:id,name", "subject:id,name");
        } else {
            $tickets = Ticket::query()->where([['assigned_to', "=", Auth::id()], ['is_closed', "=", 0]])->where('status_id', "=", $status_id)->orderBy('id', 'asc')->with("customer:id,username", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "assigned_user:id,name", "group:id,name", "subject:id,name");
        }

        $count = $tickets->count();
        return Datatables::of($tickets)
            ->editColumn('customer', function ($data) {
                return $data['customer']['username'];
            })
            ->editColumn('actions', function ($data) {
                return view('Tickets.action', compact('data'));
            })
            ->editColumn('group', function ($data) {
                return $data['group']['name'];
            })
            ->with('priorities', $priorities)
            ->with('status', $status)
            ->with('types', $types)
            ->with('count', $count)
            ->toJson();
    }

    public function inprogress_index_data(Request $request)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = Type::with('subjects')->get()->toArray();
        $tickets = [];
        $adminCanViewOnlyTicketsAssigned = Settings::get('admin_can_view_only_tickets_assigned',"");
        $adminViewAllTickets = Settings::get('admin_view_all_tickets',"[]");
        $status_id=Status::where('name','=',"New")->first()->id;
        $isAdminInAllViewList = $adminCanViewOnlyTicketsAssigned == "checked" && $this->is_admin_in_this_group(Auth::user()->classification_groups, json_decode($adminViewAllTickets));
        $isSuperAdmin = auth()->user()->hasAnyRole(['super admin']);
        
        if ($isAdminInAllViewList || $isSuperAdmin) {
            $tickets = Ticket::query()->where('is_closed', "=", 0)->where('status_id', "!=", $status_id)->with("customer:id,username", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "assigned_user:id,name", "group:id,name", "subject:id,name");
        } else {
            $tickets = Ticket::query()->where([['assigned_to', "=", Auth::id()], ['is_closed', "=", 0]])->where('status_id', "!=", $status_id)->orderBy('id', 'asc')->with("customer:id,username", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "assigned_user:id,name", "group:id,name", "subject:id,name");
        }

        $count = $tickets->count();
        return Datatables::of($tickets)
            ->editColumn('customer', function ($data) {
                return $data['customer']['username'];
            })
            ->editColumn('actions', function ($data) {
                return view('Tickets.action', compact('data'));
            })
            ->editColumn('group', function ($data) {
                return $data['group']['name'];
            })
            ->with('priorities', $priorities)
            ->with('status', $status)
            ->with('types', $types)
            ->with('count', $count)
            ->toJson();
    }

    public function unassigned_ticket(Request $request)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = Type::with('subjects')->get()->toArray();
        $tickets = Ticket::query()->where('assigned_to', '=', 0)->with("customer:id,username", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "assigned_user:id,name", "group:id,name", "subject:id,name");
        $count = $tickets->count();
        return Datatables::of($tickets)
            ->editColumn('customer', function ($data) {
                return $data['customer']['username'];
            })
            ->editColumn('actions', function ($data) {
                return view('Tickets.action', compact('data'));
            })
            ->editColumn('group', function ($data) {
                return $data['group']['name'];
            })
            ->with('priorities', $priorities)
            ->with('status', $status)
            ->with('types', $types)
            ->with('count', $count)
            ->toJson();
    }

    public function ticket_config()
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = Type::with('subjects')->get()->toArray();
        $adminViewAllTickets = json_decode(Settings::get('admin_view_all_tickets',"[]"));
        $adminViewAllUnassignedTickets = json_decode(Settings::get('admin_view_unassigned_tickets',"[]"));
        $automaticAdminAssignWay = Settings::get('automatic_admin_assign_way');
        return view('Tickets.config', compact("automaticAdminAssignWay", "priorities", "types", "status", 'adminViewAllTickets', 'adminViewAllUnassignedTickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Tickets.create", compact("ispUsers", "adminUsers", "priorities", "types", "status", "groups"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $username_ticket = $request->username_ticket;
        /*if($request->assigned_to==0){
            $userHasMaxTicketCount= User::withCount('tickets')->orderBy('tickets_count', 'asc')->get();
            $request['assigned_to']=$userHasMaxTicketCount[0]['id'];
        }*/
        if ($request->assigned_to != 0) {
            $user = User::find($request->assigned_to);
            $adminTicketsCount = $user->tickets()->where('is_closed',0)->count();
            if ($adminTicketsCount > Settings::get("open_ticket_limit")) {
                return Redirect::back()->withErrors(['Admin Ticket Limit Exceeded']);
            }
        }
        $ticket = Ticket::create($request->except(['watchers', 'attachment_url', 'customFile', 'username_ticket']));
        $subject = Subject::find($request->subject_id);
        $ticket->update(['priority_id' => $subject['priority_id']]);
        $ticket->watchers()->syncWithoutDetaching($request->watchers);

        if ($request->file('customFile')) {
            $request->validate([
                'customFile' => 'max:2048|mimes:jpeg,png,jpg,gif,svg,xlsx,xls',
            ]);
            $fileName = time() . '.' . $request->file('customFile')->extension();
            $request->file('customFile')->storeAs('public/ticketsAttachment/' . $ticket->id, $fileName);
            $ticket->update(['attachment_url' => $fileName]);
        }
        if ($username_ticket)
            return redirect('/ISP/userview/' . $username_ticket);
        return redirect()->route("tickets.index");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = TaskType::with('subjects')->get()->toArray();
        $ticket = Ticket::query()->where('id', "=", $id)->with("watchers:id,name", "customer:id,username", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "assigned_user:id,name", "group:id,name", "subject:id,name", "messages")->first();
        return view('Tickets.show', compact('ticket','priorities','status','types'));
    }

    public function download_file($id, $filename)
    {

        return response()->download(storage_path('app/public/ticketsAttachment/' . $id . '/' . $filename));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }

    public function closed_tickets(Request $request)
    {
        if ($request->has('data')) {
            $tickets = Ticket::where('is_closed',"=", 1)->with("customer:id,username", "group:id,name", "type:id,name,color", "priority:id,name,color", "status:id,name,color", "subject:id,name");
            return Datatables::of($tickets)
                ->editColumn('customer', function ($data) {
                    return $data['customer']['username'];
                })
                ->with('count', $tickets->count())
                ->toJson();
        }
        return view("Tickets.closed_tickets");
    }

    public function close_ticket(Request $request)
    {
        $restrictClosingTicket = Settings::get('restrict_closing_ticket',"[]");
        $ticket = Ticket::find($request->id);
        if ($this->admin_has_this_level(json_decode($restrictClosingTicket), Auth::user()->classification_groups)) {
            $status = Status::where('name', '=', 'Resolved')->first();
            if($ticket->tasks()->where('status_id','!=',$status->id)->exists()){
                return 'You can not close ticket (there is unresolved tasks)';
            }else{
                $date = Carbon::parse($request->startFrom)->format('Y-m-d H:i:s');
                $status= Status::where('name', '=', 'Resolved')->first();
                $ticket->update(['is_closed' => 1, 'closed_time' => $date,'status_id'=>$status->id]);
                return 'true';
            }
        } else {
            return 'You can not close ticket';
        }
    }

    public function change_priority(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->update(['priority_id' => $request->priority]);
        return 'true';
    }

    public function change_status(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $status = Status::find($request->status);
        $restrictClosingTicket = Settings::get('restrict_closing_ticket',"[]");
        
        if ( $status->name == "Resolved") {

            if(!$this->admin_has_this_level(json_decode($restrictClosingTicket), Auth::user()->classification_groups) ){
                return 'You can not change ticket status to resolved (Your level dont have this permission)';

            }
            $status = Status::where('name', '=', 'Resolved')->first();
            if($ticket->tasks()->where('status_id','!=',$status->id)->exists()){
                return 'You can not change ticket status to resolved (there is unresolved tasks)';
            }else{
                $date = Carbon::parse($request->startFrom)->format('Y-m-d H:i:s');
                $ticket->update(['is_closed' => 1, 'closed_time' => $date,'status_id'=>$status->id]);
                return 'true';
            }
        } else {
            $ticket->update(['status_id' => $request->status]);
            return "true";
        }
    }

    public function change_type(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->update(['type_id' => $request->type,'subject_id'=>$request->subject]);
        return 'true';
    }

    public function open_ticket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $start_date = new \DateTime($ticket->closed_time);
        $since_start = $start_date->diff(new \DateTime(Carbon::now()));
        if (Settings::get('re_open_within_time_value') == "Days") {
            if ($since_start->d > Settings::get('re_open_within_time')) {
                return 'false';
            }
        } elseif (Settings::get('re_open_within_time_value') == "Hrs") {
            if ($since_start->h > Settings::get('re_open_within_time')) {
                return 'false';
            }
        } else {
            if ($since_start->i > Settings::get('Mins')) {
                return 'false';
            }
        }
        $status = Status::where('name', '=', 'New')->first();
        $ticket->update(['is_closed' => 0,'status_id'=>$status->id]);
        return 'true';
    }

    public function change_read_status(Request $request)
    {
        $ticket = Ticket::find($request->id);
        if ($ticket->is_readed == 0) {
            $ticket->update(['is_readed' => 1]);
            return 1;
        } else {
            $ticket->update(['is_readed' => 0]);
            return 0;
        }
    }

    public function change_priority_values(Request $request)
    {
        $priority = Priority::find($request->id);
        $input = $request->all();
        $priority->fill($input)->save();
    }

    public function add_type(Request $request)
    {
        return Type::create($request->all());
    }

    public function delete_subject(Request $request)
    {
        $subject = Subject::find($request->id);
        $ticketOfSubject = $subject->tickets;
        if ($ticketOfSubject->isEmpty()) {
            $subject->delete();
            return 'true';
        } else {
            return "Subject has tickets please firstly remove tickets";
        }
    }

    public function add_subject(Request $request)
    {
        return Subject::create($request->all());
    }

    public function delete_type(Request $request)
    {

        $type=Type::find($request->id);
        if(count($type->tickets)>0){
            return "Type has tickets please firstly remove tickets";
        }else{
            $type->delete();
            return "true";
        }
    }

    public function change_others(Request $request)
    {
        Type::find($request->id)->update(['others' => $request->others]);

    }

    public function change_only_visible(Request $request)
    {
        Type::find($request->id)->update(['only_visible_for_admin' => $request->only_visible]);

    }

    public function get_subjects(Request $request)
    {
        return Subject::find($request->id)->type;
    }

    public function get_types()
    {
        $session = Session::get('tenant_impersonation');
        $tenant=1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        $adminUsers = User::select(["name", "id", "work_hours"])->when(Settings::get('use_time_based_on_working_hours') == "true", function ($query) {
            $today = date('l', time());
            $hour = date('H:i');
            return $query->where([['work_hours->' . $today . '->start_time', '<', $hour], ['work_hours->' . $today . '->finish_time', '>', $hour], ['work_hours->' . $today . '->work', "=", "on"]]);
        })->where('company_id',$tenant)->get();
        $groups = ClassificationGroup::select(['name', 'id'])->where('assign_ticket',1)->get();
        $types = Type::query()->select(['id', 'name'])->get()->toArray();
        $subjects = Subject::select(['id', 'name'])->get()->toArray();
        return ['types' => $types, 'groups' => $groups, 'adminUsers' => $adminUsers,'subjects'=>$subjects];
    }

    public function save_reopen_settings(Request $request)
    {
        $this->settings_update_or_create("re_open_within_time", $request->reOpenTime);
        $this->settings_update_or_create("re_open_within_time_value", $request->reOpenTimeType);

    }

    public function save_open_ticket_limit_settings(Request $request)
    {
        $this->settings_update_or_create("open_ticket_limit", $request->openTicketLimit);
    }

    public function use_time_based(Request $request)
    {
        $workHoursNullCount = User::where('work_hours', null)->count();
        if ($workHoursNullCount > 0 && $request->useTimeBased == "true") {
            return 'false';
        }
        $this->settings_update_or_create("use_time_based_on_working_hours", $request->useTimeBased);
    }

    public function automatic_admin_assign(Request $request)
    {
        $this->settings_update_or_create("automatic_admin_assign_way", $request->automaticAdminAssign);
    }

    public function settings_update_or_create($key, $value)
    {
        $session = Session::get('tenant_impersonation');
        $tenant=1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
         $setting=Settings::updateOrCreate(
            ['company_id' => $tenant,'name' => $key],
            ['val' => $value]
        );
         $setting->company_id=$tenant;
         $setting->save();
    }

    public function save_restrict_settings(Request $request)
    {
        $this->settings_update_or_create("restrict_closing_ticket", json_encode($request->levels));
    }

    public function get_admin_classification()
    {
        return ['classificationGroups' => ClassificationGroup::query()->get(), 'levels' => Level::query()->get(), 'restrict_level' => json_decode(Settings::get('restrict_closing_ticket')) == null ? [] : json_decode(Settings::get('restrict_closing_ticket'))];
    }

    public function admin_view_tickets(Request $request)
    {
        $oldValues = array();
        $key = 'admin_view_all_tickets';
        if ($request->has('type')) {
            $key = 'admin_view_unassigned_tickets';
            if (Settings::get('admin_view_unassigned_tickets')) {
                $oldValues = json_decode(Settings::get('admin_view_unassigned_tickets'));
            }
        } else {
            if (Settings::get('admin_view_all_tickets')) {
                $oldValues = json_decode(Settings::get('admin_view_all_tickets'));
            }
        }
        $object = new \stdClass();
        $object->classification_id = $request->classificationGroup;
        $object->classification_name = $request->classificationGroupName;
        $object->levels = $request->levels;
        //return $object;
       
        $existingGroup = $this->group_exist($object,$oldValues);
        $islevelExist= false;

        if($existingGroup){
            foreach($existingGroup->levels as $level){
                foreach($request->levels as $objLevel){
                    if($objLevel['name'] == $level->name){
                        $islevelExist=true;
                    }
                }
            }
        }
        if($islevelExist){
            return "Level and Group already exist";
        
        } else if($islevelExist==false && $existingGroup){
            foreach($oldValues as $oldValue){
                if($oldValue->classification_id == $existingGroup->classification_id){
                    $result = array_merge( $oldValue->levels,$request->levels);
                    //duplicate objects will be removed
                    //array is sorted on the bases of id
                    $oldValue->levels =   $result;          
                }
            }
            $session = Session::get('tenant_impersonation');
            $tenant = 1;
            if (isset($session))
                $tenant = $session;
            elseif (auth()->check())
                $tenant = auth()->user()->company_id;
    
            Settings::updateOrCreate(
                ['name' => $key,'company_id' =>$tenant],
                ['val' => json_encode($oldValues) ],
            );
            return 'true';
        }else{
            array_push($oldValues, $object);
        
            $session = Session::get('tenant_impersonation');
            $tenant = 1;
            if (isset($session))
                $tenant = $session;
            elseif (auth()->check())
                $tenant = auth()->user()->company_id;
    
            Settings::updateOrCreate(
                ['name' => $key,'company_id' =>$tenant],
                ['val' => json_encode($oldValues) ],
            );
            return 'true';
        }
      
    }
    public function group_exist($obj,$oldValues){
        foreach($oldValues as $oldValue){
            if($oldValue->classification_id == $obj->classification_id){
                return $oldValue;
            }
        }
    }

    public function delete_classification_group(Request $request)
    {
        $newArray = array();
        $settingsValues = json_decode(Settings::get('admin_view_all_tickets',"[]"));
        foreach ($settingsValues as $settingsValue) {
            if ($settingsValue->classification_id != $request->classificationGroupId) {
                array_push($newArray, $settingsValue);
            }
        }
        $session = Session::get('tenant_impersonation');
        $tenant=1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        
        Settings::where('name', 'admin_view_all_tickets')->where('company_id',$tenant)->update(
            ['val' => json_encode($newArray)],
        );
    }

    public function delete_unassignmedn_classification_group(Request $request)
    {
        $newArray = array();
        $settingsValues = json_decode(Settings::get('admin_view_unassigned_tickets',"[]"));
        foreach ($settingsValues as $settingsValue) {
            if ($settingsValue->classification_id != $request->classificationGroupId) {
                array_push($newArray, $settingsValue);
            }
        }
        $session = Session::get('tenant_impersonation');
        $tenant = 1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
       
        Settings::where('name', 'admin_view_unassigned_tickets')->where('company_id',$tenant)->update(
            ['val' => json_encode($newArray)],
        );
    }

    public function get_customer_with_live_search(Request $request)
    {

        $customer = [];
        if ($request->has('q')) {
            $search = $request->q;
            $customer = Subscriber::select("id", "username")
                ->where('username', 'LIKE', "%$search%")->orwhere("phone",'LIKE',"%$search%")->orwhere("email","Like","%$search%")->orwhere("address","Like","%$search%")
                ->get();
        }
        return response()->json($customer);
    }

    public function admin_can_view_only_assigned(Request $request)
    {
        $this->settings_update_or_create("admin_can_view_only_tickets_assigned", $request->status);
    }

    public function send_message(Request $request)
    {
        $ticketMessage = TicketMessages::create($request->except(['recipient']));
        if ($ticketMessage) {
            try {
                if ($request->model == "admin") {
                    $request->request->add(['receiver_name' => User::find($request->created_by)->name]);
                } else {
                    $request->request->add(['receiver_name' => Subscriber::find($request->created_by)]);
                }
                $newDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticketMessage->created_at)->format('Y-m-d H:i:s');
                $request->request->add(['created_at' => $newDate]);
                event(new PrivateMessageEvent($request->all()));
                return response()->json([
                    'data' => $request->all(),
                    'success' => true,
                    'message' => "message sent successfully"
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'error occured'
                ]);
            }
        }


    }

    public function get_values(Request $request)
    {        
        $model = 'App\\Models\\' . $request->model;
        $tenant = $this->get_company();
        $isSuperAdmin = auth()->user()->hasAnyRole(['super admin']);
        if(!$isSuperAdmin && ($request->model=="ClassificationGroup" || $request->model=="User" ||$request->model=="Type")){
            return response()->json($model::select(['id', 'name'])->where('company_id','=',$tenant)->get());
        }
        return response()->json($model::select(['id', 'name'])->get());
    }
    public function get_company(){
        $session = Session::get('tenant_impersonation');
        $tenant = 1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        return intval($tenant);
    }

    public function change_attribute(Request $request)
    {
        $ticket = Ticket::find($request->ticketId);
        if ($request->model == "user_id") {
            $request->merge([
                'model' => 'assigned_to',
            ]);
        } else if ($request->model == "classificationgroup_id") {
            $request->merge([
                'model' => 'group_id',
            ]);
        }
        $ticket->update([$request->model => $request->modelId]);
        return 'true';
    }

    public function is_admin_in_this_group($adminGroups, $settingsGroups)
    {
        foreach ($settingsGroups as $settingsGroup) {
            $hasGroupArray = Auth::user()->classification_groups->where('name', $settingsGroup->classification_name);
            if (count($hasGroupArray) > 0) {
                foreach ($settingsGroup->levels as $level) {
                    if ($level->name == $hasGroupArray->first()->pivot->level_name) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function admin_has_this_level($levels, $adminGroups)
    {
        $isSuperAdmin = auth()->user()->hasAnyRole(['super admin']);
        if($isSuperAdmin){
            return true;
        }
        if($levels==null){
            return false;
        }
        
        foreach ($levels as $level) {
            foreach ($adminGroups as $adminGroup) {
                if ($level->name == $adminGroup->pivot->level_name) {
                    return true;
                }
            }
        }
        return false;
    }

    public function cc_recipients(Request $request)
    {
        $session = Session::get('tenant_impersonation');
        $tenant = 1;
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        $group= ClassificationGroup::find($request->id);
        $adminUsers = $group->admins()->when(Settings::get('use_time_based_on_working_hours') == "true", function ($query) {
            $today = date('l', time());
            $hour = date('H:i');
            return $query->where([['work_hours->' . $today . '->start_time', '<', $hour], ['work_hours->' . $today . '->finish_time', '>', $hour], ['work_hours->' . $today . '->work', "=", "on"]]);
        })->where('company_id',$tenant)->get();
        return $adminUsers;
    }
    public function tasks(Request $request){
        $ticket = Ticket::find($request->id);
        return $ticket->tasks->toArray();
    }
    public function  remove_all(){
        Ticket::truncate();
        return response()->json([
            'success' => true,
            'message' => 'removed'
        ]);
    }
    public function get_tasks(Request $request){
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = TaskType::with('subjects')->get()->toArray();
        $status_id=Status::where('name','=',"New")->first()->id;
        $tasks = [];
        if($request->has('inprogress'))
        {
            $tasks = Task::query()->with(['group','subject','priority','status','type','agent','ticket'])->where('is_closed', "=", 0)->where('status_id', "!=", $status_id)->where('ticket_id', "=", $request->ticket_id);
        }else if($request->has('closed')){
            $tasks = Task::query()->with(['group','subject','priority','status','type','agent','ticket'])->where('is_closed', "=", 1)->where('ticket_id', "=", $request->ticket_id);

        }else{
            $tasks = Task::query()->with(['group','subject','priority','status','type','agent','ticket'])->where('is_closed', "=", 0)->where('status_id', "=", $status_id)->where('ticket_id', "=", $request->ticket_id);
        }
        $count = $tasks->count();
        return DataTables::of($tasks)
            ->editColumn('actions', function ($data) {
                return view('Tasks.action',compact('data'));
            })
            ->editColumn('group', function ($data) {
                return $data['group']['name'];
            })
            ->editColumn('ticket', function ($data) {
                return $data->ticket;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status')) {
                    $instance->where('ticket_id', $request->get('status'));
                }

            })
            ->with('priorities', $priorities)
            ->with('status', $status)
            ->with('types', $types)
            ->with('count', $count)
            ->toJson();
    }
    public function subjects_of_type(Request $request){
        $type = Type::find($request->type_id);
        return $type->subjects;
    }
    

}
