<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GoogleAuthMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $login;
    public $password;
    public $email;

    public function __construct($name, $login, $password, $email)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }

    public function build()
    {
        return $this->view('emails.google-auth')
                    ->subject('Успешная авторизация через Google - DigitalZone');
    }
} 