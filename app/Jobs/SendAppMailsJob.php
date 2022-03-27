<?php

namespace App\Jobs;
use Log;

use App\Mail\sendAppMails;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Mockery\Exception;

class SendAppMailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected  $subjects;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$subject)
    {

        $this->data = $data;
        $this->subjects=$subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */


    public function handle()
    {
        $template = $this->data['template'];
        $users = $this->data['users'];

        $subject=$this->subjects;
         if(!is_array($users) ) {
            if(isset($users->email)){
                log::info($users->email);
                try {

                    Mail::to($users->email )
                        ->send(new sendAppMails($template, $users, $subject));
                }
                catch (Exception $e){
                    log::info($e);

                }
            }
        }
        else {

            foreach ($users as $user) {


                if (isset($user->email)) {
                    log::info($user->email);
                    try {

                        Mail::to($user->email)
                            ->send(new sendAppMails($template, $user, $subject));
                    } catch (Exception $e) {
                        log::info($e);
                        continue;
                    }
                }

            }
        }
    }

}