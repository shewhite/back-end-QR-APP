<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $clientMail;

    public function __construct($clientMail)
    {
        $this->clientMail = $clientMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->clientMail->forUser){
            return $this->from('bipsici123456789@gmail.com')
            ->subject("New visit card from: " . $this->clientMail->company)
            ->text('informuser');
        }
        else{
            return $this->from('bipsici123456789@gmail.com')
            ->subject("New visit card from: " . $this->clientMail->company)
            //->view('views.informconnecteduser')
            ->text('informconnecteduser');
        }
    }
       
}
