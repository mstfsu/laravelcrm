<?php

namespace App\Console\Commands;

use App\Models\Settings;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignAdminToTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Admin To Unassigned Tickets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $unassignedTickets= Ticket::where([['assigned_to',0],['is_closed',0]])->with("group:id,name")->withoutGlobalScope('company_id')->get()->groupBy('company_id')->toArray();
        $today= date('l',time());
        $hour= date('H:i');
        try {
            foreach ($unassignedTickets as $tickets){
                $autoAssignWay = DB::table('settings')->where("name","=","automatic_admin_assign_way")->where("company_id","=",$tickets[0]['company_id'])->first();
                $autoAssignWay = isset($autoAssignWay)?$autoAssignWay->val:'admin_with_less_ticket';
                if($autoAssignWay){
                    $availableAdmin = User::withCount(['tickets'=>function($query){
                        $query->where('is_closed','=',0);
                    }])->with('classification_groups')->where('status_id',1)
                    ->when($autoAssignWay=="admin_with_less_ticket",function ($query){
                        $query->orderBy('tickets_count', 'asc');
                    })->when(DB::table('settings')->where("name","=","use_time_based_on_working_hours")->where("company_id","=",$tickets[0]['company_id'])->count() >0,function ($query) use ($today,$hour, $tickets){
                        
                        if(DB::table('settings')->where("name","=","use_time_based_on_working_hours")->where("company_id","=",$tickets[0]['company_id'])->first()->val=="true"){
                            return $query->where([['work_hours->'.$today.'->start_time', '<',$hour],['work_hours->'.$today.'->finish_time', '>',$hour],['work_hours->'.$today.'->work',"=","on"]]);
                        }
                    })->get()->groupBy('company_id');
                    if($autoAssignWay=="admin_with_less_ticket"){
                        $this->assign_admin_ticket_less($tickets,$availableAdmin);
                    }else if($autoAssignWay=="round_robin"){
                        $this->assign_admin_round_robin($tickets,$availableAdmin);
                    }
                }

            }

        }catch (\Exception $e){
            Log::info($e);
        }
    }
    public function assign_admin_ticket_less($unassignedTickets,$availableAdmin){
        $openTicketLimit= DB::table('settings')->where("name","=","open_ticket_limit")->where("company_id","=",$unassignedTickets[0]['company_id'])->first();
        $openTicketLimit = isset($openTicketLimit)?$openTicketLimit->val:10;
        foreach ($unassignedTickets as $ticket){
            foreach ($availableAdmin[$ticket['company_id']][0]->classification_groups as $group){
            if($ticket['group_id']==$group->id && $group->assign_ticket==1 &&$availableAdmin[$ticket['company_id']][0]->tickets_count<$openTicketLimit){
                $d = Ticket::find($ticket['id']);
                $d->update(['assigned_to'=>$availableAdmin[$ticket['company_id']][0]->id]);
                $availableAdmin->map(function ($item, $index) use ($availableAdmin,$ticket) {
                    if ($index==$ticket['company_id']) {
                        $item[0]->tickets_count=$item[0]->tickets_count+1;
                    }
                });
                $statisticCollection = collect($availableAdmin[$ticket['company_id']]);
                $availableAdmin[3] = $statisticCollection->sortBy('tickets_count')->values()->all();
                }
            }
        }
    }
    public function assign_admin_round_robin($unassignedTickets,$availableAdmin){
        $openTicketLimit= DB::table('settings')->where("name","=","open_ticket_limit")->where("company_id","=",$unassignedTickets[0]['company_id'])->first();
        $openTicketLimit = isset($openTicketLimit)?$openTicketLimit->val:10;

        foreach ($unassignedTickets as $key=>$ticket){
            $adminCount= count($availableAdmin[$ticket['company_id']]);
            $roundCycle=0;
            if ($adminCount!=1){
                $roundCycle=$key%$adminCount;
            }
            foreach ($availableAdmin[$ticket['company_id']][$roundCycle]->classification_groups as $group){
                if($ticket['group_id']==$group->id && $group->assign_ticket==1 &&$availableAdmin[$ticket['company_id']][$roundCycle]->tickets_count<$openTicketLimit){
                    $d = Ticket::find($ticket['id']);
                    $d->update(['assigned_to'=>$availableAdmin[$ticket['company_id']][$roundCycle]->id]);
                }
            }
        }
        
    }
}
