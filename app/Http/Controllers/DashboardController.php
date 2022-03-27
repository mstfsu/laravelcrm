<?php

namespace App\Http\Controllers;

use App\models\BillCustomer;
use App\Models\BillingTransactions;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\NAS;
use App\models\PaymentNew;
use App\Models\Radacct;
use App\Models\Subscriber;
use App\Models\Ticket;
use App\models\Transaction;
use App\Charts\MonthlyUsersChart;
use App\Charts\OnlineChart;
use App\Charts\OnlineCharts;

use Illuminate\Http\Request;
use App\Models\OnlineStatistics;
use DB;
use Carbon\Carbon;
use Landlord;
use Session;
use App\Models\Company;
use App\Models\RenewCustomer;
class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }
  public function dashboardISP(){
 
      $session =Session::get('tenant_impersonation');
      if(isset($session))
          $tenant=$session;
      else
          $tenant = auth()->user()->company_id;
      $today=Carbon::today()->format('Y-m-d');
      /* registeration*/
      $totalregisteration=Subscriber:: count();
      $registeration=Subscriber:: whereDate('created_at', Carbon::today())->count();
      $registeration_week = Subscriber:: whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
      $registeration_month= Subscriber:: whereMonth('created_at', date('m'))
          ->whereYear('created_at', date('Y'))
          ->count();
      /* active*/

      $totalactive=Subscriber::where('status','active')->count();
      $active_daily=Subscriber::where('status','active')->whereDate('activated_at', Carbon::today())->count();
      $active_week = Subscriber::where('status','active')->whereBetween('activated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
      $active_month= Subscriber::where('status','active')->whereMonth('activated_at', date('m'))
          ->whereYear('activated_at', date('Y'))
          ->count();

   /*expired*/
      $totalexpire=Subscriber::whereDate('expiration','<',$today)->count();
      $expired_daily=Subscriber:: whereDate('expiration',Carbon::today())->count();
      $expired_week = Subscriber::whereBetween('expiration', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
      $expired_month= Subscriber:: whereMonth('expiration', date('m'))
          ->whereYear('expiration', date('Y'))
          ->count();
/*blocked*/
      $block_total=Subscriber::where('status','blocked') ->count();
      $block_daily=Subscriber::where('status','blocked')->whereDate('blocked_at',Carbon::today())->count();
      $block_week = Subscriber::where('status','blocked')->whereBetween('blocked_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
      $block_month= Subscriber::where('status','blocked')-> whereMonth('blocked_at', date('m'))
          ->whereYear('blocked_at', date('Y'))
          ->count();


      $currentMonthInvoices = Invoice::query()->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
      $lastMonthInvoices = Invoice::query()->whereMonth('created_at', \Carbon\Carbon::now()->subMonth(1)->month)->get();
      $currentMonth = BillingTransactions::query()->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
      $lastMonth = BillingTransactions::query()->whereMonth('created_at', \Carbon\Carbon::now()->subMonth(1)->month)->get();
      $opened_tickets=Ticket::where('is_closed',0)->count();
      $closed_tickets=Ticket::where('is_closed',1)->count();
      $new_tickets=Ticket::where('status_id',1)->count();
      $total_tickets=$opened_tickets+$closed_tickets;

      $pageConfigs = ['pageHeader' => false];
      return view('Dashboard.dashboard', ['pageConfigs' => $pageConfigs],compact('currentMonthInvoices','lastMonthInvoices','currentMonth','lastMonth','opened_tickets','closed_tickets','new_tickets','total_tickets','tenant','totalregisteration','registeration_month','registeration','registeration_week','totalactive','active_daily','active_month','active_week','expired_daily','expired_week','expired_month','block_month','block_daily','block_week','totalexpire','block_total'));
  }
  public  function get_dashboard_data(){



  }
  public function get_counters_data(){
      $today=Carbon::today()->format('Y-m-d');

      $allusers=Subscriber::count();
      $blocked_users=Subscriber::where('status','blocked')->count();
      $new_users=Subscriber::where('status','new')->count();
      $expired_users=Subscriber::whereDate('expiration',"<",$today)->count();
      $lead=Lead::count();
      $routers=NAS::count();
      $clients=Subscriber::groupBy('status')->select('status', DB::raw('count(*) as total'))->get();
      $lead_status_table=LeadStatus::withCount('leads')->with('leads')->get();






      foreach ($lead_status_table as $leads){
          $leads->deal=$leads->leads()->sum('leads.deal');
          if($leads->id==1)
              $leads->status_name = 'primary';
          elseif($leads->id==2)
              $leads->status_name = 'info';
          elseif($leads->id==3)
              $leads->status_name = 'warning';
          elseif($leads->id==4)
              $leads->status_name = 'success';
          elseif($leads->id==5)
              $leads->status_name = 'danger';
      }






      $data=array();
      $data['blocked_users']=$blocked_users;
      $data['expired_users']=$expired_users;
      $data['new_users']=$new_users;
      $data['allusers']=$allusers;
      $data['leads']=$lead;
      $data['routers']=$routers;
      $data['clients']=$clients;
      $data['leadstable']=$lead_status_table;


      return json_encode($data);

  }

    public function checkmem( )
    {
        return   $percentage = $this->getMemoryUsage();

        $message = "usage at {$percentage}%";

    }
    public function getMemoryUsage()
    {
        $fh = fopen('/proc/meminfo', 'r');
        $mem = 0;
        $all_str = '';

        while ($line = fgets($fh)) {
            $all_str .= $line;
        }
        fclose($fh);

        preg_match_all('/(\d+)/', $all_str, $pieces);

        $used=$pieces[0][0]-$pieces[0][1];


        $data[0]=$used/1024/1024;
        $data[1]=$pieces[0][0];

        return json_encode( $data);
    }

    public function checkcpu( )

    {   $load = sys_getloadavg();
        return json_encode( $this->getServerLoad());
        //     echo  $message = "usage at {$usage}%";





    }


    function _getServerLoadLinuxData()
    {
        if (is_readable("/proc/stat"))
        {
            $stats = @file_get_contents("/proc/stat");

            if ($stats !== false)
            {
                // Remove double spaces to make it easier to extract values with explode()
                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find line for main CPU load
                foreach ($stats as $statLine)
                {
                    $statLineData = explode(" ", trim($statLine));

                    // Found!
                    if
                    (
                        (count($statLineData) >= 5) &&
                        ($statLineData[0] == "cpu")
                    )
                    {
                        return array(
                            $statLineData[1],
                            $statLineData[2],
                            $statLineData[3],
                            $statLineData[4],
                        );
                    }
                }
            }
        }

        return null;
    }

    // Returns server load in percent (just number, without percent sign)
    function getServerLoad()
    {
        $data=array();

        $load = null;

        if (stristr(PHP_OS, "win"))
        {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);

            if ($output)
            {
                foreach ($output as $line)
                {
                    if ($line && preg_match("/^[0-9]+\$/", $line))
                    {
                        $load = $line;
                        break;
                    }
                }
            }
        }
        else
        {
            if (is_readable("/proc/stat"))
            {
                // Collect 2 samples - each with 1 second period
                // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
                $statData1 = $this->_getServerLoadLinuxData();
                sleep(1);
                $statData2 = $this->_getServerLoadLinuxData();

                if
                (
                    (!is_null($statData1)) &&
                    (!is_null($statData2))
                )
                {
                    // Get difference
                    $statData2[0] -= $statData1[0];
                    $statData2[1] -= $statData1[1];
                    $statData2[2] -= $statData1[2];
                    $statData2[3] -= $statData1[3];

                    // Sum up the 4 values for User, Nice, System and Idle and calculate
                    // the percentage of idle time (which is part of the 4 values!)
                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                    // Invert percentage to get CPU time, not idle time
                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                }
            }
        }

        return $load;
    }

    protected function getDiskUsagePercentage()
    { $used= disk_free_space("/");
        $total=disk_total_space("/");
        $data[0]=$total;
        $data[1]=$used;
        return json_encode ($data);
        //  return (int) Regex::match('/(\d?\d)%/', $command);
    }

    public function  get_online_data(Request $request){
        $date_range=$request->date_range;
        $session =Session::get('tenant_impersonation');
        if(isset($session))
            $tenant=$session;
        else
            $tenant = $request->user()->company_id;

        $company=Company::withoutGlobalScope('company_id')->where('id',$tenant)->first();
        $query=new OnlineStatistics();
        if($tenant==1) {


            $query->setTable("online_statistics");
            $query =  $query-> withoutGlobalScope('company_id')->where('company_id', $tenant);
        }
        else{
            $table_name=$company->name;
            if(isset($company->table_name))
            $table_name=$company->table_name;


           
            $query->setTable($table_name);


        }

        if($date_range=="1Hour")
        {
            $cond=Carbon::today()->format('Y-m-d');
            $query= $query->select(DB::raw('count'),DB::raw('DATE_FORMAT(created_at,"%H:%i") as  date_x'))->where('created_at',">=", Carbon::now()->subHours(1)->toDateTimeString());
            $data=$query->get();
        }
        if($date_range=="6Hour")
        {
            $cond=Carbon::today()->format('Y-m-d');
            $query= $query->select(DB::raw('count'),DB::raw('DATE_FORMAT(created_at,"%H:%i") as  date_x'))->where('created_at',">=", Carbon::now()->subHours(6)->toDateTimeString());
            $data=$query->get();
        }
        if($date_range=="12Hour")
        {
            $cond=Carbon::today()->format('Y-m-d');
            $query= $query->select(DB::raw('count'),DB::raw('DATE_FORMAT(created_at,"%H:%i") as  date_x'))->where('created_at',">=", Carbon::now()->subHours(12)->toDateTimeString());
            $data=$query->get();
        }
        if($date_range=="24Hour")
        {
            $cond=Carbon::today()->format('Y-m-d');
            $query= $query->select(DB::raw('count'),DB::raw('DATE_FORMAT(created_at,"%H:%i") as  date_x'))->where('created_at',">=", Carbon::now()->subHours(24)->toDateTimeString());
            $data=$query->get();
        }
        if($date_range=="Today")
        {
            $cond=Carbon::today()->format('Y-m-d');
           $query= $query->select(DB::raw('count'),DB::raw('DATE_FORMAT(created_at,"%H:%i") as  date_x'))->whereDate('created_at',$cond);
            $data=$query->get();
        }
        if($date_range=="Yesterday")
        {
            $cond=Carbon::yesterday()->format('Y-m-d');
           $query= $query->select('count',DB::raw('MINUTE(created_at) as  date_x'))->whereDate('created_at',$cond);
            $data=$query->get();
        }
        if($date_range=="Week")
        {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d');
            $data=Radacct::select(DB::raw('Date(acctstarttime) as  date_x'),DB::raw('count(distinct username) as count')  )->whereDate('acctstarttime','>=',$weekStartDate)->whereDate('acctstarttime','<=',$weekEndDate) ->groupby('date_x') ->get() ;

         // $query=  $query->select('count',DB::raw('DATE(created_at) as  date_x'))->whereDate('created_at','>=',$weekStartDate)->whereDate('created_at','<=',$weekEndDate);
        }
        if($date_range=="Month")
        {
            $start = new Carbon('first day of this month');
            $start=Carbon::parse($start);
            $start=$start->format('Y-m-d');
            $end = new Carbon('last day of this month');
            $end=Carbon::parse($end);
            $end=$end->format('Y-m-d');
            $data=Radacct::select(DB::raw('Date(acctstarttime) as  date_x'),DB::raw('count(distinct username) as count')  ) ->whereDate('acctstarttime','>=',$start)->whereDate('acctstarttime','<=',$end)->groupby('date_x') ->get() ;

           // $query=  $query->select('count',DB::raw('DATE(created_at) as  date_x'))->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end);
        }


        $x_array=array();
        $y_array=array();
        foreach ($data as $dash){
            array_push($x_array,$dash->date_x);
            array_push($y_array,$dash->count);
        }
        return json_encode(['data_x'=>$x_array,"data_y"=>$y_array]);
    }
    public function get_ticket_data(Request $quest){
     $all_tickets=Ticket::count();
     $closed_ticket=Ticket::where('is_closed',1)->count();
     if($all_tickets>0)
        $percent=round(($closed_ticket*100)/$all_tickets);
     else
         $percent=0;
        return json_encode(['percent'=>$percent]);
    }
    public function get_users_data(){
        $admin_id=auth()->user()->id;
      $data=array();
      $labels=array('New','Active','Blocked','Expired');

        $today=Carbon::today()->format('Y-m-d');
        if(auth()->user()->hasAnyRole(['super admin','administrator','manager'])) {
            $allusers = Subscriber::count();
            $blocked_users = Subscriber::where('status', 'blocked')->count();
            $new_users = Subscriber::where('status', 'new')->count();
            $expired_users = Subscriber::whereDate('expiration', "<", $today)->count();
            $active_users = Subscriber::where('status', 'active')->count();
        }
        else{
            $allusers = Subscriber::where('owner',$admin_id)->count();
            $blocked_users = Subscriber::where('status', 'blocked')->where('owner',$admin_id)->count();
            $new_users = Subscriber::where('status', 'new')->where('owner',$admin_id)->count();
            $expired_users = Subscriber::whereDate('expiration', "<", $today)->where('owner',$admin_id)->count();
            $active_users = Subscriber::where('status', 'active')->where('owner',$admin_id)->count();
        }

        array_push($data,$new_users);
        array_push($data,$active_users);
        array_push($data,$blocked_users);
         array_push($data,$expired_users);
   $colors=array('#098eec','#49a53e','#ec2a2a','#e26d19');

        return json_encode(['data'=>$data,"labels"=>$labels,'total'=>$allusers,'colors'=>$colors]);




    }
    public function get_leads_data(Request $request)
    {
         // $leads = Lead::select( DB::raw('count(*) as total'),'status_id')->with('status')->groupBy('status_id')->get();
//         foreach($leads as $lead)
//         {
//
//
//         }
        $last_seven_days=Carbon::now()->subDays(14);
         $this_seven_days= Carbon::now()->subDays(7);
          $this_won_leads=Lead::where('status_id',4)->whereDate('updated_at','>=',$this_seven_days)->count();
          $last_won_leads=Lead::where('status_id',4)->whereDate('updated_at','<=',$this_seven_days)->whereDate('updated_at','>=',$last_seven_days)->count();
          $diff=$this_won_leads-$last_won_leads;



        $totaleads=Lead::count();

          $leads=LeadStatus::where('id','!=',3)->get();
          foreach($leads as $lead){
              $lead->count=$lead->leads()->count();
              if($lead->id==1){
                  $lead->color="primary";
              }
              if($lead->id==2){
                  $lead->color="warning";
              }
              if($lead->id==4){
                  $lead->color="success";

              }
              if($lead->id==5){
                  $lead->color="danger";
              }

          }
          $leads_chart=Lead::select(DB::raw('count(*) as total'),DB::raw('DATE(updated_at) as won_date'))->whereDate('updated_at','>=',$this_seven_days)->groupby('updated_at')->get();
         $lead_array=array();
        $date_array=array();
        $color_array=array();
          foreach ($leads_chart as $chart){
              array_push($lead_array,$chart->total);
              array_push($date_array,$chart->won_date);
              array_push($color_array,"#877df2");
          }


          return json_encode(['leads_group'=>$leads,'total'=>$totaleads,'diff'=>$diff,'color_array'=>$color_array,'lead_array'=>$lead_array,"date_array"=>$date_array]);
    }

}
