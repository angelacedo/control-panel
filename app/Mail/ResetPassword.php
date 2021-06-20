<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;
     
    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $id;
    public $username;
    public $hash;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $username, $hash)
    {
        $this->id = $id;
        $this->username = $username;
        $this->hash = $hash;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('angel.acedo.test@example.com')
                    ->view('resetpassword');
    }
}