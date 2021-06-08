<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FaultCategory extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    protected $table = 'fault_categories';

    public function faults(){
        return $this->hasMany('App\Fault', 'fault_id', 'name');
    }

    public function getFaultCountForUser(){
        $user = Auth::user();
        $projects = $user->projects()->pluck('projects.id')->toArray();
        return $this->faults()->whereIn('project_id',$projects)->count();
    }
}
