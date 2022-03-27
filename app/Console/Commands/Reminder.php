<?php

namespace App\Console\Commands;

use App\Http\Controllers\CardsController;
use App\Jobs\SendAppMailsJob;
use App\Models\MessageTemplate;
use App\Models\SendSMS;
use App\Models\Settings;
use App\Models\Subscriber;
use App\User;
use Carbon\Carbon;
use Carbon\Exceptions\BadComparisonUnitException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Expire:Remind';

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
    {   $users_array=array();
        $account_expiry_alert=Settings::get('account_expiry_alert');
        $email_template_id=Settings::get('email_reminder_template');
        $sms_template_id=Settings::get('sms_reminder_template');
        $email_template=MessageTemplate::find($email_template_id);
        $sms_template=MessageTemplate::find($sms_template_id);
        $first_reminder=Settings::get('reminder_day_1');
        $second_reminder=Settings::get('reminder_day_2');
        $third_reminder=Settings::get('reminder_day_3');
          $first_reminder_day=Carbon::today()->addDays($first_reminder);
        $second_reminder_day=Carbon::today()->addDays($second_reminder);
        $third_reminder_day=Carbon::today()->addDays($third_reminder);
         $users=Subscriber::whereDate('expiration',$first_reminder_day)->orwhereDate('expiration',$second_reminder_day)->orwhereDate('expiration',$third_reminder_day)->get();
        foreach ($users as $user){
            $SingleUser = [
                'name' => $user->fullname,
                'email' => $user->email,
                'expire'=>$user->expiration,
                'password'=>$user->password

            ];
            array_push($users_array, $SingleUser);
            if(Str::contains($account_expiry_alert,'sms')) {
                $sms = new SendSMS(1,$sms_template->message);

                $sms->send_message($user);
            }
        }


        $data = [
            'users' => $users_array,
            'template' => $email_template->message
        ];
        if(Str::contains($account_expiry_alert,'email'))
        dispatch(new SendAppMailsJob($data,"subject"));











    }
}
