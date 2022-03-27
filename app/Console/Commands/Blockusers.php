<?php

namespace App\Console\Commands;

use App\Models\Settings;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Blockusers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'User:Block';

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
         $invoiceduedate=Settings::get('invoice_should_paid_in');
         $today=Carbon::today();
         $users=Subscriber::query()->whereHas('invoices', function ($q) use($invoiceduedate,$today){
          //   return $q->whereDate('date_payment', '<=', $now);
           return  $q->whereRaw("date_payment + interval $invoiceduedate day <= ?", [$today])->where('status','not_paid');
         })->where('status','!=','blocked')->get();
         if(Settings::get('disable_account_due_unpaid_invoice')==1) {
             foreach ($users as $user) {

                 $user->status = 'blocked';
                 $user->reason_block = "Blocked by system   Due Unpaid ";
                 $user->save();

             }
         }
         else{
             $expire_plan=Settings::get('expired_account_plan');
             foreach ($users as $user) {
                 $user->srvid=$expire_plan;
                 $user->status = 'active';
                 $user->save();
             }
         }
    }
}
