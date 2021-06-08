<div class="container-fluid" style=" width: 100%; background: #efefef">
    <div class="container profilepagecontainer ">
        <div class="row">
            <div class="col-md-6 col-sm-6 mt-4">
                <div class="project_name">{{$project->project_name}}</div>

                <div class="mt-5 project_text">Inspection Date: <span>{{$project->survey}}</span></div>
                <div class="project_text">Capacity: <span>{{$project->total_dc_capacity_mw}} MW</span></div>
                <div class="project_text">Module Type: <span>{{ $project->module }}</span></div>

                <div class="col-md-6 coll-sm-6 mt-5">
                    <a href="{{route('profile.index')}}">
                        <button class="btn btn-block btn-success dashboard mt-5"><img src="{{asset('img/back.png')}}" class="arrw float-left" >Project Portfolio</button>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6" style="background-image: url({{ ($project->project_avatar =='no_avatar') ? asset('img/ssite_03.png') : asset(str_replace(' ','','/storage/companies/'.$project->company->name.'/'.$project->project_name.$project->id.'/'.$project->project_avatar)) }}); background-size: 100% 100%">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid profilePageContent">
    <div class="container mb-4 profilePageContent">
        <div class="row mt-5 d-flex justify-content-center navbar align-items-start">
            <div class="col-sm-2 col-md-2 text-center ">
                <a href="{{ route('project.analytics',['id'=>$project->id]) }}" class="nav-link text-dark">Analytics</a>
            </div>
            <div class="col-sm-2 col-md-2 text-center">
                <a href="{{ route('project.map',['id'=>$project->id]) }}" class="nav-link text-dark">Map</a>
            </div>
            <div class="col-sm-2 col-md-2 text-center">
                <a href="{{route('project.database',['id'=>$project->id])}}" class="nav-link text-dark">Database</a>
                <hr class="hrStyle">
            </div>
        </div>
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-md-3 col-sm-3 offset-1">
                <form action="{{route('project.database',['id'=>$project->id])}}" class="form-horizontal" method="post" id="faultsArrangeBy">
                    @csrf
                    <select class="form-control" name="faultsArrangeBy" id="arrange_database">
                        <option value="fault_no">Arrange By Fault Number</option>
                        <option value="fault_id">Arrange By Fault Id</option>
                        <option value="substation">Arrange By Substation</option>
                        <option value="hot_spot_analysis">Arrange By Hotspot fault</option>
                    </select>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <form method='post' action={{route('project.report',['id'=>$project->id])}}>
                    @csrf
                    <input type="submit" name="exportcsv" class="btn btn-outline-secondary" value='Download Report(.csv)'>
                </form>
            </div>
        </div>
        <div class="row mt-5">
                <table id="database_table_sticky_header" >

                    <thead class="text-center">
                        <tr>
                            <th scope="col">Fault #</th>
                            <th scope="col">Site row</th>
                            <th scope="col">Fault ID</th>
                            <th scope="col">Substation</th>
                            <th scope="col">Hotspot fault</th>
                            <th scope="col">Inverter</th>
                            <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;String&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">Module</th>
                            <th scope="col">Module row</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Co-ordinates</th>
                            <th scope="col">Imagery</th>
                            <th scope="col">Map</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @foreach($faults as $fault)
                            <tr>
                                <td>{{$fault->fault_no}}</td>
                                <td>{{$fault->site_row}}</td>
                                <td>{{$fault->fault_id}}</td>
                                <td>{{$fault->substation}}</td>
                                <td>{{$fault->hot_spot_analysis ?? '-'}}</td>
                                <td>{{$fault->inverter}}</td>
                                <td>{{$fault->string_number}}</td>
                                <td>{{$fault->module}}</td>
                                <td>{{$fault->table_row}}</td>
                                <td>{{$fault->comment ?? '-'}}</td>
                                <td>{{$fault->lat}},{{$fault->long}}</td>
                                <td >
                                    <div class="d-flex">
                                        <button class="digital btn btn-outline-secondary" data-digitalimg="{{$fault->digital_image_name}}"><i class="fa fa-camera camera"></i></button>
                                        <button class="thermal btn btn-outline-secondary ml-1" data-thermalimg="{{$fault->thermal_image_name}}"><i class="fa fa-thermometer-half camera"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('project.map',['id'=>$project->id, 'lat'=>$fault->lat, 'long'=>$fault->long, 'color'=>$faultCategory[$fault->fault_id], 'faultId'=>$fault->fault_id, 'string'=>$fault->string_number, 'module'=>$fault->module, 'thermal'=>$fault->thermal_image_name] )}}" class="mapRedirect btn btn-outline-secondary" data-lat="{{$fault->lat}}" data-long="{{$fault->long}}"><i class="fa fa-map-marker"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            <div class="offset-4 col-xs-3 col-md-3">{{ $faults->links() }}</div>
        </div>
    </div>
</div>

<div id="databaseModal" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <img id="modalImg" class=""  src="" alt="" style="width:465px;height:465px; transform: rotate(180deg)">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#arrange_database').on('change', function(){
            let form = $('#faultsArrangeBy');
            let sortBy = form.find(':selected').val();
            window.sessionStorage.setItem('faultsArrangeBy', sortBy);
            form.submit();
        });
        let optionValue = sessionStorage.getItem('faultsArrangeBy');
        $('#faultsArrangeBy').val(optionValue).find('option[value='+optionValue +']').attr('selected', true);




        $('.digital').on('click', function () {
            let img = window.location.protocol +'//'+ window.location.hostname + '/storage/companies/' + "{{str_replace(' ','',$project->company->name.'/'.$project->project_name.$project->id)}}" +'/Digital Images/' + this.dataset.digitalimg + '.jpg';
            $(".modal-body #modalImg").attr("src", img);
            $('#databaseModal').modal('show')
        });
        $('.thermal').on('click', function () {
            let imgSrc = window.location.protocol +'//'+ window.location.hostname + '/storage/companies/' + "{{str_replace(' ','',$project->company->name.'/'.$project->project_name.$project->id)}}" +'/Thermal Images/' + this.dataset.thermalimg + '.jpg';
            let img = $(".modal-body #modalImg");
            img.attr("src", imgSrc);
            $('#databaseModal').modal('show');
        });

    })
</script>
