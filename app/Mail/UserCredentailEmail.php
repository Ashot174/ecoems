<?php

namespace App\Mail;

use App\SiteConfig;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;


class UserCredentailEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $userInfo = null;
    private $password = null;

    /**
     * UserCredentailEmail constructor.
     * @param User $user
     * @param $password
     */
    public function __construct(User $user,$password)
    {
        $this->userInfo = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->userInfo;
        $password = $this->password;
        $logoConf = SiteConfig::first();
        $logo = $logoConf?$logoConf->logo:'logo/logo.png';
        return $this->from(config('mail.from.address'))->subject('Login Credentials')->view('email.registration',compact('user','logo','password'));
    }
}
