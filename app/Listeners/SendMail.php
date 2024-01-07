<?php

namespace App\Listeners;

use App\Events\LogHistoryLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LogHistoryLogin $event): void
    {
        // https://www.tutorialspoint.com/laravel/laravel_sending_email.htm
        $data = array('name' => "Virat Gandhi");
        Mail::send('emails.mail', $data, function ($message) {
            /** @var Mailable $message */
            $message->to('ductv44@fpt.edu.vn', 'Tutorials Point')
                ->cc(['truongzeeeeee@gmail.com', 'anhnt683@gmail.com'])
                ->attach(asset('favicon.ico'))
                ->bcc('namdpph26892@fpt.edu.vn')
                ->subject('Laravel Basic Testing Mail');
        });
    }
}
