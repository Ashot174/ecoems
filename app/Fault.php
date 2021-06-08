<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fault extends Model
{
    //

    protected $fillable =[
       'project_id' ,'fault_no','fault_id', 'hot_spot_analysis', 'substation', 'inverter', 'string_number','module','site_row','table_row','comments','lat','long','thermal_image_name','digital_image_name'
    ];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function faultCategory(){
        return $this->belongsTo('App\FaultCategory','fault_id', 'name');
    }
}
