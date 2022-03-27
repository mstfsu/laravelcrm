<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Storage;
use Illuminate\Support\Str;
use Session;

class TemplatesController extends Controller
{
    public  function index(Request $request){

       return view('MessageTemplates.index');

    }
    public  function add_template(Request $request){
        $name=$request->name;
        $description=$request->description;
        $template_type=$request->template_type;
        $msg=$request->msg;
        $template=new MessageTemplate();
        $template->name=$name;
        $template->description=$request->description;
        $template->message=$msg;
        $template->type=$template_type;
        $template->partner_id=request()->user()->id;
        $res=$template->save();
        if($res)
        echo json_encode(['success' => "true", "msg" => "Added successfully"]);
      else {
        echo json_encode(['success' => "false", "msg" => "Error ! Please try again Later !"]);
}


    }

    public function get_templates(Request $request){
        $admin_id=\Auth::user()->id;
        $data=MessageTemplate::query()->where('partner_id',$admin_id)->get();
        return Datatables::of($data)

            ->addColumn('action', function ($data) {

              return view('Actions.Messages_template',compact('data'));
            })

            ->editColumn('name', function ($data) {

                $name = '<strong>'.$data->name.'</strong>';
                return $name;
            })
            ->editColumn('type', function ($data) {
                   if($data->type=='sms')
                $type =  "<div class='badge badge-info'>SMS</div>";
                if($data->type=='email')
                    $type =  "<div class='badge badge-success'>EMAIL</div>";
                return $type;
            })



            ->rawColumns(['name','type' ])


            ->make(true);
    }
    public function edit_template(Request $request){
        $name=$request->name;
        $description=$request->description;
        $template_type=$request->template_type;
        $msg=$request->msg;
        $id=$request->id;

        $template= MessageTemplate::findorfail($id);
        $template->name=$name;
        $template->description=$description;
        $template->message=$msg;
        $template->type=$template_type;
        $template->partner_id=request()->user()->id;
        $res=$template->save();
        if($res)
            echo json_encode(['success' => "true", "msg" => "Saved successfully"]);
        else {
            echo json_encode(['success' => "false", "msg" => "Error ! Please try again Later !"]);
        }
    }

    public  function delete_template(Request $request){
        $id=$request->id;
        $template=MessageTemplate::findorfail($id);
        $res=$template->delete();
        if($res){
            echo json_encode(['success' => "true", "msg" => "deleted successfully"]);

        }
        else {
            echo json_encode(['success' => "false", "msg" => "Error ! Please try again Later !"]);
        }

    }
}
