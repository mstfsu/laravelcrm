<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Subscriber;
use App\Models\Radacct;
use App\Models\NAS;
use Illuminate\Support\Facades\Log;

class ClearStaleSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      echo  $date = Carbon::now()->subMinutes(30)->format("Y-m-d H:i:s");
        $newdate=Carbon::parse($date)->format('Y-m-d');;
        echo $time = Carbon::parse($date)->toTimeString();
       $data = Radacct::withoutGlobalScope("company_id")->where('acctupdatetime',  "<",$date)->whereNull('acctstoptime')->get();


//

//
//
        foreach ($data as $user) {
            echo $user->username . " radacct ";

            $this->disconnect_user($user,"radacct" );
            //  $radacct=Radacct::withoutGlobalScope('company_id')->where('username',$user->username)->whereNull('acctstoptime')->update(['acctstoptime'=>Carbon::now()]);

            //    $subscriber=Subscriber::withoutGlobalScope('company_id')->where('username',$user->username)->first();

        }
        $stale = Subscriber::withoutGlobalScope('company_id')->doesntHave('onlineuser')->where('onlinestatus', 'online')->get();
               foreach ($stale as $user) {
            echo $user->username . " stale ";

            $this->disconnect_user($user,"stale" );

        }

    }

    public function disconnect_user($user,$type){
        log::info("disconnect function");
        $username=$user->username;

        if($type=="radacct") {
            $router=NAS::withoutGlobalScope('company_id')->where('shortname',$user->nasipaddress)->first();
            $res=  exec("echo user-name=$username | radclient -x $router->shortname:$router->coa disconnect $router->secret");
            echo("echo user-name=$username | radclient -x $router->shortname:$router->coa disconnect $router->secret");

            Subscriber::withoutGlobalScope('company_id')->where('username',$username)->update(['onlinestatus'=>"offline"]);
            Radacct::withoutGlobalScope('company_id')->where('username',$username)->whereNull('acctstoptime')->update(['acctstoptime'=>Carbon::today()->format('Y-m-d H:i:s')]);


            $res=  exec("echo user-name=$user->framedipaddress | radclient -x $router->shortname:$router->coa disconnect $router->secret");
            log::info("echo user-name=$user->framedipaddress | radclient -x $router->shortname:$router->coa disconnect $router->secret");



        }
        else{
            Subscriber::withoutGlobalScope('company_id')->where('username',$username)->update(['onlinestatus'=>"offline"]);

            echo  json_encode(['success' => "false", "msg" => "Error ! this user is not connected!.$username"]);
        }

    }
}
