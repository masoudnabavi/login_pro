<?php

namespace masoudnabavi\login_pro\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthMails extends Mailable
{
    use Queueable, SerializesModels;
    public $inputs;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
          $this->inputs=$request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('This Is authentications Mail')->view('login_pro::mails.mailView');
    }
}
