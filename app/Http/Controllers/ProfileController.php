<?php

namespace App\Http\Controllers;

use App\FaultCategory;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends SiteController
{
    //
    protected $vars = array();

    public function __construct()
    {
        $this->middleware('auth');
        $this->template = 'profile.profile';
    }

    public function index(Request $request){
        if($request->isMethod('post')){
            session(['projectsSortBy'=> $request->projectsSortBy]);
        }

        $sortedBy = session('projectsSortBy', 'project_name');
        $projects = $this->projectPortfolio($sortedBy);
        $numberOfProjects = count($projects);
        $content = view('profile.content_profile',compact(['projects','numberOfProjects']))->render();
        $this->vars['content'] = $content;
        return $this->renderOutput();
    }


    protected function projectPortfolio($sortBy = 'project_name'){
        $projects = $this->getProjects();
        $items = array();
        foreach ($projects as $project){
            $project['modules_affected'] = (count($project->faults)/$project->total_no_modules)*100;
            $items[] = $project;
        }
        $columns = array_column($items, $sortBy);
        array_multisort($columns, SORT_ASC, $items);

        return $items;
    }

    public function projects(Request $request){
        if($this->getProjects()->isEmpty()){
            abort(404);
        }
        $faultsCategories = FaultCategory::select('name','color')->get();
        if($request->isMethod('post')){
            $projects = $this->projectPortfolio($request->projectsSortBy);
        }else{
            $projects = $this->projectPortfolio();
        }

        $module_types = $this->getProjects()->groupBy('module');

        $numberOfProjects = count($projects);
        $countByFaultsCategories = array();
        $siteSummaryChart = array();
        if(isset($projects)) {
            foreach ($projects as $project) {
                $faults = $project->faults;
                foreach ($faultsCategories as $faultCategory) {
                    $countByFaultsCategories['heading'][$faultCategory->name] = $faultCategory->name;
                    $countByFaultsCategories[$project->project_name.$project->id][$faultCategory->name] = $faults->where('fault_id', $faultCategory->name)->count();
                    $siteSummaryChart[$project->project_name.$project->id][$faultCategory->name] = $faults->where('fault_id', $faultCategory->name)->count();
                    $siteSummaryChart[$project->project_name.$project->id]['capacity'] = $project->total_dc_capacity_mw;
                }
                if ($countByFaultsCategories) {
                    array_unshift($countByFaultsCategories[$project->project_name.$project->id], $project->project_name, $project->module);
                    array_push($countByFaultsCategories[$project->project_name.$project->id], count($faults));
                }
            }


            if($countByFaultsCategories) {
                array_unshift($countByFaultsCategories['heading'], 'Project Name', 'Module');
                array_push($countByFaultsCategories['heading'], 'Total');
            }

        }

        if($request->isMethod('post')){
            return json_encode($siteSummaryChart);
        }

        $content = view('profile.content_profile_summary',compact(['countByFaultsCategories','numberOfProjects','faultsCategories','siteSummaryChart','module_types']))->render();
        $this->vars['content'] = $content;


        return $this->renderOutput();
    }


    protected function getProjects(){
        $projects = Auth::user()->projects;
        $projects->load('faults');
        return $projects;
    }

}
