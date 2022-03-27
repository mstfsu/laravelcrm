<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\ClassificationGroup;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Subject;
use App\Models\Subscriber;
use App\Models\Task;
use App\Models\TaskSubjects;
use App\Models\TaskType;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = TaskType::with('subjects')->get()->toArray();
        return view('Tasks.index',compact( "priorities", "types", "status"));
    }
    public function index_Data(Request $request)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = TaskType::with('subjects')->get()->toArray();
        $status_id=Status::where('name','=',"New")->first()->id;
        $tasks = [];

        if($request->has('inprogress'))
        {
            $tasks = Task::query()->with(['group','subject','priority','status','type','agent','ticket'])->where('is_closed', "=", 0)->where('status_id', "!=", $status_id);
        }else if($request->has('closed')){
            $tasks = Task::query()->with(['group','subject','priority','status','type','agent','ticket'])->where('is_closed', "=", 1);

        }else{
            $tasks = Task::query()->with(['group','subject','priority','status','type','agent','ticket'])->where('is_closed', "=", 0)->where('status_id', "=", $status_id);
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return 'Success, task added to this ticket';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = TaskType::with('subjects')->get()->toArray();
        $task = Task::query()->with('subject')->with('priority')->with('status')->with('type')->with('agent')->find($id);
        $ticket = $task->ticket;
        return view('Tasks.show',compact('ticket','task','status','types','priorities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
    public function config()
    {
        $priorities = Priority::get()->toArray();
        $status = Status::select(['name', 'color', 'id'])->get();
        $types = TaskType::with('subjects')->get()->toArray();
        return view('Tasks.config',compact('priorities','status','types'));
    }
    public function add_type(Request $request)
    {
        return TaskType::create($request->all());
    }
    public function add_subject(Request $request)
    {
        return TaskSubjects::create($request->all());
    }
    public function delete_type(Request $request)
    {
        $taskyType = TaskType::find($request->id);
        if(count($taskyType->tasks)>0){
            return "Type has tasks please firstly remove tasks";
        }else{
            $taskyType->delete();
            return "true";
        }
    }
    public function delete_subject(Request $request)
    {
        $subject = TaskSubjects::find($request->id);
        $tasksOfSubject = $subject->tasks;
        if ($tasksOfSubject->isEmpty()) {
            $subject->delete();
            return 'true';
        } else {
            return "Subject has tasks please firstly remove tasks";
        }
    }
    public function get_types(Request $request)
    {
        $groups = ClassificationGroup::with('agents')->find($request->group_id);
        $types = TaskType::query()->select(['id', 'name'])->get()->toArray();
        return ['types' => $types, 'groups' => $groups];
    }
    public function get_subjects(Request $request)
    {
        return TaskType::find($request->id)->subjects;
    }
    public function change_priority(Request $request)
    {
        $task = Task::find($request->id);
        $task->update(['priority_id' => $request->priority]);
        return 'true';
    }
    public function change_status(Request $request)
    {
        $task = Task::find($request->id);
        $status = Status::find($request->status);
        if ($status->name == "Resolved") {
            $task->update(['status_id' => $request->status, 'is_closed' => 1]);
        } else {
            $task->update(['status_id' => $request->status]);
        }
        return $status;
    }
    public function change_type(Request $request)
    {
        $task = Task::find($request->id);
        $task->update(['task_type_id' => $request->type,'task_subject_id'=>$request->subject]);
        return 'true';
    }
    public function close_ticket(Request $request)
    {
        $date = Carbon::parse($request->startFrom)->format('Y-m-d H:i:s');
        $task = Task::find($request->id);
        $status= Status::where('name', '=', 'Resolved')->first();

        $task->update(['is_closed' => 1, 'closed_time' => $date,'status_id'=>$status->id]);
        return 'true';
         
    }
    public function remove_all(){
        Task::truncate();
        return response()->json([
            'success' => true,
            'message' => 'removed'
        ]);
    }
    public function get_ticket_with_live_search(Request $request){
        $ticket = [];
        if ($request->has('q')) {
            $search = $request->q;
            $subject  = Subject::where('name', 'LIKE', "%$search%")->pluck('id')->toArray();

            $ticket = Ticket::whereIn('subject_id', $subject)
                ->with('subject')
                ->get();
        }
        return response()->json($ticket);
    }
    public function subjects_of_type(Request $request){
        $type = TaskType::find($request->type_id);
        return $type->subjects;
    }

}
