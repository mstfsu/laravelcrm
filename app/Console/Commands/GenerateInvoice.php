<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Settings;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Invoice:generate';

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
        $today=Carbon::today()->format('Y-m-d');
        $customers=Subscriber::query()->whereHas('profiles',function ($q){
            return $q->where('type_of_billing','recurring');
        })->whereDate('expiration',$today)->get();
        $pay_day=Settings::get('invoice_should_paid_in');
        if($pay_day)
            $payment_day=Carbon::parse($today)->addDays($pay_day);
        else
            $payment_day=Carbon::parse($today)->addDays(1);
       foreach ($customers as $customer){
           $number=Carbon::now()->format('Ymd');
           $extra=rand(00000,999999);
           $number =$number.$extra;
           $invoice = new Invoice();
           $invoice->customer_id = $customer->id;
           $invoice->date_created = $today;
           $invoice->date_payment = $payment_day;
           $invoice->memo = "Generated By system";
           $invoice->note = 'Generated By system';
           $invoice->total = $customer->profiles->total_price;
           $invoice->number = $number;
           $invoice->added_by_id = 1;
           $invoice->real_create_datetime = Carbon::now()->format('Y-m-d H:i:s');
           $res = $invoice->save();
       }




    }
}