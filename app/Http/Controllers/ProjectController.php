<?php

namespace App\Http\Controllers;

use App\Fault;
use App\FaultCategory;
use Illuminate\Http\Request;
use App\Project;
use DB;
use Excel;
use App\Exports\ProjectExport;
use Illuminate\Support\Facades\Auth;

class ProjectController extends SiteController
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->template = 'project.project';
    }

    public function analytics($id){
        if(!in_array($id,$this->getProjectsIdsOfAuthUser())){
            abort(404);
        }
        $project = Project::findOrFail($id);
        $faultsCategories = FaultCategory::select('name','color')->get();
        $project->load('faults');
        //$project->faults->load('faultCategory');
        $faults = $project->faults;

        /*Start Site Efficiency*/
        $efficiency = number_format(($project->total_no_modules -$project->faults->count())/$project->total_no_modules *100,1,'.', '');
        $incapacity = number_format($project->faults->count()/$project->total_no_modules *100,1,'.', '');
        $forSiteEfficiencyChart =['efficiency'=>$efficiency, 'incapacity'=>$incapacity];
        /*end Site Efficiency*/



        /*Start Site Fault Summary & Faults per MW*/
        $forSiteFaultSummaryChart = array();
        $forTotalFaultsPerMW = array();
        foreach ($faultsCategories as $faultCategory) {
            $countByFaultsCategory = $faults->where('fault_id', $faultCategory['name'])->count();
            $forSiteFaultSummaryChart[$faultCategory->name]['count'] = $countByFaultsCategory;
            $forSiteFaultSummaryChart[$faultCategory->name]['color'] = $faultCategory['color'];
            $forTotalFaultsPerMW[$faultCategory->name]['countPerMw'] = number_format($countByFaultsCategory/$project->total_dc_capacity_mw, 1, '.', '');
            $forTotalFaultsPerMW[$faultCategory->name]['color'] = $faultCategory['color'];
        }
        /*End Site Fault Summary & Faults per MW*/



        /*Start Substation Defect Summary*/
        $substationGroupedBy = $project->faults->groupBy(['substation', 'fault_id']);
        $substationDefectSummary = array();
        foreach ($substationGroupedBy as $key=> $substation){
            $countAllFaultsSubstation = 0;
            foreach ($faultsCategories as $category){
                $substationDefectSummary[$key][$category->name] = isset($substation[$category->name]) ? $substation[$category->name]->count() : '0';
                $countAllFaultsSubstation+=$substationDefectSummary[$key][$category->name];
            }
            array_unshift($substationDefectSummary[$key], $key);
            array_push($substationDefectSummary[$key],$countAllFaultsSubstation);
        }
        $totalsByCategory = array();
        foreach ($faultsCategories as $category){
            $totalsByCategory[$category->name] = $faults->where('fault_id', $category->name)->count();
        }
        array_push($totalsByCategory,$faults->count());
        array_unshift($totalsByCategory, 'Overall Totals');
        array_push($substationDefectSummary, $totalsByCategory);
        /*end Substation Defect Summary*/


        /*Start Total Hotspot Defects*/
        $projectHotSpots = $faults->where('fault_id', 'Hotspot');

        $hotSpots = $projectHotSpots->groupBy('hot_spot_analysis');
        $forHotSpotDefectsChart = array();
        foreach ($hotSpots as $key=> $hotspot){
            $forHotSpotDefectsChart[$key]['count'] = $hotspot->count();
            if($key == 'Vegetation'){
                $forHotSpotDefectsChart[$key]['color'] = "#b3174b";
            }elseif($key == 'Soiling'){
                $forHotSpotDefectsChart[$key]['color'] = '#e498b2';
            }elseif($key == 'Investigate'){
                $forHotSpotDefectsChart[$key]['color'] = '#cc3366';
            }else{
                $forHotSpotDefectsChart[$key]['color'] = '#d8668b';
            }
        }

        $columns = array_column($forHotSpotDefectsChart, 'color');
        array_multisort($columns, SORT_DESC, $forHotSpotDefectsChart);
        /*End Total Hotspot Defects*/



        /*Start Substation Hotspot Summary*/
        $hotSpotsBySubstation = $projectHotSpots->groupBy(['substation','hot_spot_analysis']);
        $hotSpotSummary = array();
        foreach ($hotSpotsBySubstation as $key=>$substation){
            $countSubstationHotSpots = 0;
            foreach ($hotSpots as $cause=> $hotspot){
                $hotSpotSummary[$key][$cause] = isset($substation[$cause]) ? $substation[$cause]->count() : '0';
                $countSubstationHotSpots+=$hotSpotSummary[$key][$cause];
            }
            array_push($hotSpotSummary[$key],$countSubstationHotSpots);
            array_unshift($hotSpotSummary[$key],$key);
        }
        /*End Substation Hotspot Summary*/

        /*Start Total PID Defects & PID Severity Levels*/
        $projectPIDs = $faults->where('fault_id', 'PID');
        $pids = $projectPIDs->groupBy('hot_spot_analysis');
        $forPIDDefectsChart = array();
        foreach ($pids as $key=> $pid){
            $pidSeverity = explode(' ',trim($key));
            $forPIDDefectsChart[$pidSeverity[0]]['count'] = $pid->count();
            if($pidSeverity[0] == 'Light'){
                $forPIDDefectsChart[$pidSeverity[0]]['color'] = "#98b2e4";
            }elseif($pidSeverity[0] == 'Moderate'){
                $forPIDDefectsChart[$pidSeverity[0]]['color'] = '#668bd8';
            }else{
                $forPIDDefectsChart[$pidSeverity[0]]['color'] = '#3366cc';
            }
        }

        $columns = array_column($forPIDDefectsChart, 'color');
        array_multisort($columns, SORT_DESC, $forPIDDefectsChart);
        /*End Total PID Defects & PID Severity Levels*/



        /*Start Substation PID Summary*/
        $pidsBySubstation = $projectPIDs->groupBy(['substation','hot_spot_analysis']);
        $pidSummary = array();
        foreach ($pidsBySubstation as $key=>$substation){
            $countSubstationPIDs = 0;
            foreach ($pids as $category=> $pid){
                $cause = explode(' ',trim($category));

                $pidSummary[$key][$cause[0]] = isset($substation[$category]) ? $substation[$category]->count() : '0';
                $countSubstationPIDs+=$pidSummary[$key][$cause[0]];
            }
            array_push($pidSummary[$key],$countSubstationPIDs);
            array_unshift($pidSummary[$key],$key);
        }

        /*End Substation PID Summary*/

        $content = view('project.content_analytics',compact('project','forSiteEfficiencyChart', 'forSiteFaultSummaryChart', 'forTotalFaultsPerMW', 'substationDefectSummary', 'faultsCategories', 'forHotSpotDefectsChart','hotSpotSummary','forPIDDefectsChart', 'pidSummary'))->render();
        $this->vars['content'] = $content;
        return $this->renderOutput();
    }


    public function map($id){
        if(!in_array($id,$this->getProjectsIdsOfAuthUser())){
            abort(404);
        }
        $project = Project::findOrFail($id);
        $project->load('faults');
        $project->faults->load('faultCategory');
        $faultsArray = $project->faults->map(function ($item, $key) {
            $itemCurrent = collect($item)->except(['id', 'project_id', 'created_at','updated_at'])->toArray();
            $itemCurrent['color'] = isset($item->faultCategory->color) ? $item->faultCategory->color: '#38c172';
            return $itemCurrent;
        });
        $fault_categories = FaultCategory::pluck('name');

        $content = view('project.content_map',compact('project', 'faultsArray', 'fault_categories'))->render();
        $this->vars['content'] = $content;

        return $this->renderOutput();
    }

    public function database(Request $request,$id){
        if(!in_array($id,$this->getProjectsIdsOfAuthUser())){
            abort(404);
        }
        if($request->isMethod('post')){
            session(['faultsArrangeBy'=> $request->faultsArrangeBy]);
        }

        $arrangeBy = session('faultsArrangeBy', 'fault_no');
        $project = Project::findOrFail($id);
        $project->load('faults');
        $project->faults->load('faultCategory');
        $faultCategory = FaultCategory::pluck('color', 'name');

        $faults = DB::table('faults')->select('fault_no','site_row','fault_id','hot_spot_analysis','substation','inverter','string_number','module','table_row','comments','lat','long','thermal_image_name', 'digital_image_name')->where('project_id', $project->id)->orderBY($arrangeBy)->paginate(100);
        //dd($faults);
        $content = view('project.content_database',compact('project','faults', 'faultCategory'))->render();
        $this->vars['content'] = $content;
        return $this->renderOutput();
    }

    public function export($id) {
        $project = Project::findOrFail($id);
        $projectArray['Project Name'] = $project['project_name'];
        $projectArray['Inspection date'] = $project['survey'];
        $projectArray['Capacity'] = $project['total_dc_capacity_mw'];
        $projectArray['Module'] = $project['module'];

        $faultsArray = $project->faults->map(function ($item, $key) {
            return collect($item)->except(['id', 'project_id', 'created_at','updated_at'])->toArray();
        });

        $arrays = [$projectArray,$faultsArray];
        return Excel::download(new ProjectExport($arrays), 'report.csv');
    }

    private function getProjectsIdsOfAuthUser(){
        return Auth::user()->projects()->pluck('projects.id')->toArray();
    }
}
