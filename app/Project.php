<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    protected $casts = [
        'date_of_survey' => 'datetime:d/m/Y'
    ];

    protected $fillable =[
        'company_id','project_name','project_address', 'lat', 'long', 'module', 'total_no_modules', 'total_dc_capacity_mw','total_substation', 'survey', 'project_avatar'
    ];

    public function company(){
        return $this->belongsTo('App\Company');
    }

    public function faults(){
        return $this->hasMany('App\Fault');
    }

    public function getFaultsByCategory($category){
        return $this->faults()->where('fault_id',$category);
    }

//    public function faultCategory(){
//        return $this->hasManyThrough(
//            'App\FaultCategory',
//            'App\Fault',
//            'project_id',
//            'name',
//            'id',
//            'fault_id'
//            );
//}

}
