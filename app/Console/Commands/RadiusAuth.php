<?php

namespace App\Console\Commands;

use App\Models\CustomerOnline;
use App\Models\Subscriber;
use App\Models\TrafficCounter;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
class RadiusAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radius:auth  {User-Name} {Password} {Calling-Station-Id} {NAS-Port} {NAS-IP-Address} {Framed-Protocol} {Framed-IP-Address} ';

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
        $username = $this->argument('User-Name');
        $password = $this->argument('Password');
        $callingstationid=$this->argument('Calling-Station-Id');
        $nas_port=$this->argument('NAS-Port');
        $nasipaddress=$this->argument('NAS-IP-Address');
        $framedipprotocol=$this->argument('Framed-Protocol');
        $framedipaddress=$this->argument('Framed-IP-Address');

          $user=Subscriber::with('profiles')->withCount('iscusomeronline')->where('username',$username)->first();
           echo $counter=TrafficCounter::select(DB::raw('up + down as test'))->where('user_id',$user->id)->first();

         if($user){
             $expiredate =Carbon::parse( $user->expiration);
             $today = Carbon::now();
             if($user->enableuser==0 || $today > $expiredate) {
                 echo 'REJECT';
                 exit();
             }
             if($user->iscusomeronline_count>=$user->profiles->sim_usage)
             {
                 echo 'REJECT';
                 exit();
             }

           echo   $counter=TrafficCounter::select(DB::raw('up + down'))->where('user_id',$user->id);



             






             echo  'ACCEPT';
         }
         else{
             echo  'REJECT';
         }

    }
}
