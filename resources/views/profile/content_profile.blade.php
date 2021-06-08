<div class="container-fluid profilepage"  style=" width: 100%; background: #efefef;">
    <div class="container profilepagecontainer">
        <div class="row">
            <div class="col-md-6 col-sm-6 mt-4">
                <div class="project_portfolio">Project Portfolio</div>
                @if ($numberOfProjects >1)
                    <div class="col-md-6 col-sm-6 mb-3">
                        <form action="{{route('profile.index')}}" class="form-horizontal" method="post" id="projectsSortBy">
                            @csrf
                            <div class="d-flex float-left" >
                                <span class="mr-2 align-self-center">Sort: </span>
                                <select  class="form-control" name="projectsSortBy" id="sort">
                                    <option value="project_name">Alphabetical</option>
                                    <option value="survey">Inspection Date</option>
                                    <option value="total_dc_capacity_mw">Capacity</option>
                                    <option value="modules_affected">Modules effected</option>
                                </select>
                            </div>
                        </form>
                    </div>
                @endif
                <div class="col-md-6 col-sm-6 mt-5">
                    <p>Number of projects: {{ $numberOfProjects }}</p>
                </div>
                @if ($numberOfProjects !=0)
                    <div class="col-md-6 coll-sm-6 mt-5">
                        <a href="{{route('projects.show')}}">
                            <button class="btn btn-block btn-success dashboard">Portfolio Summary<img src="{{asset('img/next.png')}}" class="arrw float-right"></button>
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-sm-6" style="background-image: url({{ (Auth::user()->avatar !== "users/default.png") ? asset('/storage/'.Auth::user()->avatar) : asset('logo/111.jpg')}}); background-size: 100% 100%;">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid profilePageContent">
    <div class="container mb-2 profilePageContent">
        <div class="profile_sitename">
            @if(isset($projects))
            <div class="row">
                @foreach ($projects as $project)
                        <div class="col-md-3 col-sm-4">
                            <div class="sitepadding">
                                <div class="col-md-12 col-sm-12 mb-3" style="background-image: url({{ ($project->project_avatar =='no_avatar') ? asset('img/ssite_03.png') : asset(str_replace(' ','','/storage/companies/'.$project->company->name.'/'.$project->project_name.$project->id.'/'.$project->project_avatar)) }}); background-size: 100% 100%; height:300px">
                                </div>
                                <div>
                                    <a href="{{ route('project.analytics',['id'=>$project->id]) }}">
                                        <button class="btn btn-block btn-success dashboard" style="font-size: 20px">{{ $project->project_name }}<img src="{{asset('img/next.png')}}" class="arrw float-right"></button>
                                    </a>
                                    <div style="font-size: 15px" class="mt-2">Inspection date: <span>{{$project->survey}}</span></div>
                                    <div style="font-size: 15px">Capacity: <span>{{$project->total_dc_capacity_mw}} MW</span></div>
                                    <div style="font-size: 15px">Module type: <span>{{ $project->module }}</span></div>
                                    <hr>
                                    <div style="font-size: 15px">Modules affected: <span class="font-weight-bold lead" style="font-size: 30px">{{number_format($project->modules_affected, 2, '.', '')}} %</span></div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#sort').on('change', function(){
            let form = $('#projectsSortBy');
            let sortBy = form.find(':selected').val();
            window.sessionStorage.setItem('projectSortBy', sortBy);
            form.submit();
        });
        let optionValue = sessionStorage.getItem('projectSortBy');
        $('#projectsSortBy').val(optionValue).find('option[value='+optionValue +']').attr('selected', true);


    })
</script>

