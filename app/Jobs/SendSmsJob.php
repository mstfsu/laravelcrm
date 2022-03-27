<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SendSMS;
use App\Modesl\Subscriber;
use Log;
class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected  $msg;
    protected  $users;
    public function __construct($users,$msg)
    {
        $this->users=$users;
        $this->msg=$msg;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $msg=$this->msg;
        $users=$this->users;

log::info($users);
     if(!is_array($users) ){
         $sms = new SendSMS($users->company_id, $msg);
         $sms->send_message($users);
    }
else {
    foreach ($users as $user) {

        $sms = new SendSMS($user->company_id, $msg);
        $sms->send_message($user);
    }
}
        //
    }
}
