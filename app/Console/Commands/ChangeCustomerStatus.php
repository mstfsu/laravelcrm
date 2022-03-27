<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Subscriber;
use App\Models\Radacct;
use App\Models\NAS;
class ChangeCustomerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:change';

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
    {       $today = Carbon::now()->format('Y-m-d');
           $users=Subscriber::whereDate('expiration','<=',$today)->where('status','!=','expired')->get();
           foreach($users as $user){
               $this->disconnect($user->username);
               $user->status="expired";
               $user->save();
           }
    }
    public function disconnect($username){
        // $users=Subscriber::with('Usersstatus')->get();
        $users=Radacct::withoutGlobalScope('company_id')->where('username',$username)->whereNull('acctstoptime')->get();
        if($users) {

            foreach ($users as $user) {


                $router = NAS::withoutGlobalScope('company_id')->where('shortname', $user->nasipaddress)->first();
                if ($router)
                    exec("echo user-name=$username | radclient -x $router->shortname:$router->coa disconnect $router->secret");

            }
        }
        else{
            $user = Subscriber::withoutGlobalScope('company_id')->where('username', $username)->first();
            if ($user) {
                $router = NAS::withoutGlobalScope('company_id')->where('shortname', $user->nasipaddress)->first();
                if ($router)
                    exec("echo user-name=$username | radclient -x $router->shortname:$router->coa disconnect $router->secret");

                $user->onlinestatus = "offline";
                $user->save();
            }
        }
    }
}
