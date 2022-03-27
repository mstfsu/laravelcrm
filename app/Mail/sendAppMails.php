<?php

namespace App\Mail;

use App\Models\Settings;
use Log;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendAppMails extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $template;
    protected $subjects;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template,$user,$subjects)
    {   log::info("constrrrrrrrrrrrr".$subjects);
        $this->template = $template;
        $this->user = $user;
        $this->subjects = $subjects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */


    public function build(){


        $app_name =  Settings::get('organization_name');
        $fromEmail = Settings::get('email');
        $subject=$this->subjects;
        $content=$this->template;


        $content = str_replace('{name}', $this->user->fullname, $content);
        $content = str_replace('{username}', $this->user->username, $content);
        $content = str_replace('{email}', $this->user->email, $content);
        $content = str_replace('{password}', $this->user->password, $content);
        $content = str_replace('{expire}', $this->user->expiration, $content);
        $content = str_replace('{app_name}', $app_name, $content);




        return $this->from($fromEmail, $app_name)
        ->subject($subject)
        ->view('EmailTemplates.template',[
            'content'  =>   $content
        ]);
    }
}
