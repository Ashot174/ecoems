<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * @var array
     */
    protected $table = 'companies';

    protected $guarded = [];


    public function users(){
        return $this->belongsToMany('App\User', 'company_user', 'company_id', 'user_id')
            ->using('App\Pivots\CompanyUser');
    }

    public function projects(){
        return $this->hasMany('App\Project');
    }
}
