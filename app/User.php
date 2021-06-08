<?php

namespace App;

use App\Mail\UserCredentailEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id', 'company_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies(){
        return $this->belongsToMany('App\Company', 'company_user', 'user_id', 'company_id')
            ->using('App\Pivots\CompanyUser');
    }

    public function projects(){
        return $this->hasManyThrough(
            'App\Project',
            'App\Pivots\CompanyUser',
            'user_id',
            'company_id',
            'id',
            'company_id'
        );
    }


}
