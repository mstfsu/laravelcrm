<?php

namespace App\Console\Commands;

use App\Jobs\SendAppMailsJob;
use App\Models\MessageTemplate;
use App\Models\SendSMS;
use App\Models\Settings;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ExpireNoti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Expire:Notif';

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
        $users_array=array();
        $account_expiry_alert=Settings::get('account_expiry_alert');
        $email_template_id=Settings::get('email_expiry_template');
        $sms_template_id=Settings::get('sms_expiry_template');
        $email_template=MessageTemplate::find($email_template_id);
        $sms_template=MessageTemplate::find($sms_template_id);

        $expire_day=Carbon::today()->format('Y-m-d');

        $users=Subscriber::whereDate('expiration',$expire_day)->get();
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
