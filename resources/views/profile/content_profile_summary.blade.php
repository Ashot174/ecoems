<div class="container-fluid profilepage" style=" width: 100%; background: #efefef">
    <div class="container profilepagecontainer" >
        <div class="row">
            <div class="col-md-6 col-sm-6 mt-4">
                <div class="project_portfolio">Portfolio Summary</div>

                    <div class="col-md-6 col-sm-6 mb-3 mt-5">
                        <p>Number of projects: {{ $numberOfProjects }}</p>
                    </div>
                    <div class="col-md-6 coll-sm-6 mt-5">
                        <a href="{{route('profile.index')}}">
                            <button class="btn btn-block btn-success dashboard"><img src="{{asset('img/back.png')}}" class="arrw float-left" >Project Portfolio</button>
                        </a>
                    </div>
            </div>
            <div class="col-md-6 col-sm-6" style="background-image: url({{ (Auth::user()->avatar !== "users/default.png") ? asset('/storage/'.Auth::user()->avatar) : asset('logo/111.jpg')}}); background-size: 100% 100%;">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid profilePageContent">
    <div class="container mb-2 profilePageContent">
        @if(!empty($countByFaultsCategories))
            <section id="project-summary" class="row mt-5 table-responsive border border-secondary">
                    <table class="table table-hover ">
                        @foreach($countByFaultsCategories as $countByFaultCategory)
                            <tr>
                                @if($loop->first)
                                    @foreach($countByFaultCategory as $field)
                                        <th scope="col" class="text-left" >{{$field}}</th>
                                    @endforeach
                                @else
                                    @foreach($countByFaultCategory as $field)
                                        @if ($loop->last)
                                            <td class="text-center font-weight-bold">{{ $field }}</td>
                                        @else
                                            <td class="text-center">{{ $field }}</td>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </table>
            </section>
        @endif

        @if (!empty($siteSummaryChart))
            <section class="row mt-3 border p-2 table-responsive border-secondary graph">
                <div class="text-center mt-3">
                    Site Summary (faults per MW)
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <span class="align-self-center mr-2 ml-5">Sort: </span>
                    <div class="col-md-3 col-sm-3">
                        <div class="col-md-10 col-sm-10">
                            <select class="form-control" name="projectsSortBy" id="sort">
                                <option value="project_name">Alphabetical</option>
                                <option value="survey">Inspection Date</option>
                                <option value="total_dc_capacity_mw">Capacity</option>
                                <option value="modules_affected">Modules effected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="site_summary_div" class="text-center mt-3 col-md-12 position-relative">
                    <canvas id="site_summary"></canvas>
                </div>
                <div class="offset-1 col-sm-10 col-md-10 mt-5 d-flex justify-content-around graph_color_box">
                    @foreach($faultsCategories as $faultCategory)
                        <div>
                            <div class="d-flex justify-content-around">
                                <div class="color-box" style="background-color: {{$faultCategory->color}}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-around mt-2">
                                {{$faultCategory->name}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="row mt-3 border p-2 table-responsive border-secondary graph">
                <div class="text-center mt-3 mb-3">
                    Fault Type Summary
                </div>
    {{--            <div class="text-center col-md-2 col-sm-2 offset-5 mt-4">--}}
    {{--                <select class="form-control"  name="projectsSortBy" id="">--}}
    {{--                    <option value="project_name">Alphabetical</option>--}}
    {{--                    <option value="survey">Inspection Date</option>--}}
    {{--                    <option value="total_dc_capacity_mw">Capacity</option>--}}
    {{--                    <option value="modules_affected">Modules effected</option>--}}
    {{--                </select>--}}
    {{--            </div>--}}
                <div class="fault_type_div mt-3">
                    <canvas id="fault_type"></canvas>
                </div>
            </section>

            <section class="row mt-3 mb-3 border p-2 table-responsive border-secondary graph">
                <div class="text-center mt-3 mb-3">
                    Module Type Summary
                </div>
    {{--            <div class="text-center col-md-2 col-sm-2 offset-5 mt-4">--}}
    {{--                <select class="form-control"  name="projectsSortBy" id="">--}}
    {{--                    <option value="project_name">Alphabetical</option>--}}
    {{--                    <option value="survey">Inspection Date</option>--}}
    {{--                    <option value="total_dc_capacity_mw">Capacity</option>--}}
    {{--                    <option value="modules_affected">Modules effected</option>--}}
    {{--                </select>--}}
    {{--            </div>--}}
                <div>
                    <canvas id="module_type" ></canvas>
                </div>
                <div class="offset-1 col-sm-10 col-md-10 mt-5 d-flex justify-content-around graph_color_box">
                    @foreach($faultsCategories as $faultCategory)
                        <div>
                            <div class="d-flex justify-content-around">
                                <div class="color-box" style="background-color: {{$faultCategory->color}}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-around mt-2">
                                {{$faultCategory->name}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
</div>
</div>

<script>
    Chart.defaults.global.defaultFontStyle = 'bold';
    var barOptions_stacked = {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                right: 40,
                left: 25
            }
        },
        tooltips: {
            enabled: true,
            mode: 'nearest'
        },
        hover :{
            animationDuration:0
        },
        scales: {
            xAxes: [{
                gridLines:{
                    display:false
                },
                ticks: {
                    beginAtZero:false,
                    fontFamily: "'Century Gothic', sans-serif",
                    fontSize:17,
                    padding: 30,

                },
                scaleLabel:{
                    display:false,
                    labelString:'Faults per mw'
                },
                stacked: true,
            }],
            yAxes: [{
                barPercentage: 0.5,
                categoryPercentage: 1.6,
                gridLines: {
                    display:false,
                    color: "#fff",
                    zeroLineColor: "#fff",
                    zeroLineWidth: 0,
                },
                ticks: {
                    //fontFamily: "'Open Sans Bold', sans-serif",
                    fontFamily: "Century Gothic",
                    fontSize:18,
                    fontColor: 'black',
                    padding: 60
                },
                stacked: true
            }]
        },

        legend:{
            display:false,
            position: 'bottom',
            labels: {
                fontSize:20,
                boxWidth:15
            }
        },
        pointLabelFontFamily : "Century Gothic",
        scaleFontFamily : "Century Gothic",
    };

    @if(!empty($siteSummaryChart))

        var ctx = document.getElementById("site_summary");
        @if($numberOfProjects==1)
            ctx.height = 140;
        @else
        ctx.height = (110-{{ $numberOfProjects }}*5)*{{ $numberOfProjects }};
        @endif
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [
                    @foreach($siteSummaryChart as $key => $countByFaultCategory)
                                "{{preg_replace ( '/[0-9]*$/' , '' , $key)}}",
                    @endforeach
                ],

                datasets: [

                    @foreach($faultsCategories as $category)
                        {
                        showLine:false,
                            data: [
                                @foreach($siteSummaryChart as $key => $countByFaultCategory)
                                        {{number_format($countByFaultCategory[$category->name]/$countByFaultCategory['capacity'], 1, '.', '')}},
                                @endforeach
                            ],
                            backgroundColor: "{{$category->color}}"
                        },
                    @endforeach
                ]
            },

            options: barOptions_stacked,
        });
    var faultsPerMw = document.createElement("p");
    faultsPerMw.innerHTML = 'Faults per MW';
    document.getElementById('site_summary_div').appendChild(faultsPerMw);
    @if($numberOfProjects==1)
        faultsPerMw.style.cssText = 'position:absolute; top:77%; left:9%; font-size:14px';
    @elseif($numberOfProjects==2)
        faultsPerMw.style.cssText = 'position:absolute; top:84%; left:9%; font-size:14px';
    @elseif($numberOfProjects==3)
        faultsPerMw.style.cssText = 'position:absolute; top:89%; left:9%; font-size:14px';
    @elseif($numberOfProjects==4)
        faultsPerMw.style.cssText = 'position:absolute; top:91%; left:9%; font-size:14px';
    @elseif($numberOfProjects==5)
        faultsPerMw.style.cssText = 'position:absolute; top:92.5%; left:9%; font-size:14px';
    @else
        faultsPerMw.style.cssText = 'position:absolute; top:93%; left:9%; font-size:14px';
    @endif

        $('#sort').on('change',function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('projects.show')}}',
                method: 'post',
                data:{'projectsSortBy':this.value},
                success:function (data) {
                    console.log(data)
                    var arr_label = [];
                    $.each(JSON.parse(data), function( index, value ) {

                        if(index!='heading'){
                            arr_label.push(index.replace(/[0-9]/g, ''));
                        }
                    });
                    data = {
                        labels: arr_label,
                        datasets:[
                                @foreach($faultsCategories as $category)
                            {
                                label: "{{$category->name}}",
                                data: $.map(JSON.parse(data), function( value, index ) {
                                    if(index!='heading'){
                                        var x = '{{$category->name}}';
                                        return (value[x]/value['capacity']).toFixed(1);
                                    }
                                }),
                                backgroundColor: "{{$category->color}}",
                                // hoverBackgroundColor: "rgba(50,90,100,1)"
                            },
                            @endforeach
                        ]
                    };
                    myChart.data = data;
                    myChart.update();
                }
            })
        });


    @endif

    var module_ctx = document.getElementById('module_type');
    @if(count($module_types)==1)
        module_ctx.height = 140;
    @else
        module_ctx.height = (115-{{ count($module_types) }}*5) * {{count($module_types)}};
    @endif
    var module_type = new Chart(module_ctx,{
        type: 'horizontalBar',
        data: {
            labels: [
                @foreach($module_types as $key => $module)
                    "{{$module[0]->module}}",
                @endforeach
            ],

            datasets: [
                    @foreach($faultsCategories as $category)
                {
                    label: "{{$category->name}}",
                    data: [
                        @foreach($module_types as $module)
                            @php $sum = 0; @endphp
                            @foreach($module as $mod)
                                @php $sum += $mod->getFaultsByCategory($category->name)->count(); @endphp
                            @endforeach
                            "{{$sum}}",
                        @endforeach
                    ],
                    backgroundColor: "{{$category->color}}"
                },
                @endforeach
            ]
        },

        options: barOptions_stacked,
    });

    var fault_ctx = document.getElementById('fault_type');
    @if(count($faultsCategories)==1)
        fault_ctx.height = 140;
    @else
        fault_ctx.height = (120-{{ count($faultsCategories) }}*5)* {{count($faultsCategories)}};
    @endif
    barOptions_stacked.legend = {
        display:false
    };
    var fault_type = new Chart(fault_ctx,{
        type: 'horizontalBar',
        data: {
            labels: [
                @foreach($faultsCategories as  $category)
                    "{{$category->name}}",
                @endforeach
            ],

            datasets: [
                {
                    data: [
                        @foreach($faultsCategories as  $category)
                            "{{$category->getFaultCountForUser()}}",
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($faultsCategories as  $category)
                            "{{$category->color}}",
                        @endforeach
                    ]
                }
            ]
        },

        options: barOptions_stacked,
    })
</script>
