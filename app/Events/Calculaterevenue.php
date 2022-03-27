<?php

namespace App\Events;
use App\Models\Revenue;
use App\Models\Totalrevenue;
use App\Models\Company;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;
class Calculaterevenue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $companies=Company::withoutGlobalScope('company_id')->get();
        foreach($companies as $company){

            $company_id=$company->id;
            $sum=0;
            $revenues=Revenue::withoutGlobalScope('company_id')->where('added_tototal',0)->where('company_id',$company_id)->get();
            foreach ($revenues as $revenue){
                log::info("we are here in event");
               // $sum+=$revenue->revenue;
                $revenue->added_tototal=1;
                $revenue->save();
                $totalrev=Totalrevenue::withoutGlobalScope('company_id')->firstorcreate(['company_id'=>$company_id]);
                $newrev =$revenue->revenue+$totalrev->total;
                $totalrev->total=$newrev;
                $totalrev->save();
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
     //   return new PrivateChannel('channel-name');
    }
}
