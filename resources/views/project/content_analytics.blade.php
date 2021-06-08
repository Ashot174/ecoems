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
                <a href="#" class="nav-link text-dark">Analytics</a>
                <hr class="hrStyle">
            </div>
            <div class="col-sm-2 col-md-2 text-center">
                <a href="{{ route('project.map',['id'=>$project->id]) }}" class="nav-link text-dark">Map</a>
            </div>
            <div class="col-sm-2 col-md-2 text-center">
                <a href="{{route('project.database',['id'=>$project->id])}}" class="nav-link text-dark">Database</a>
            </div>
        </div>
        <div class="row mt-5 d-flex">
            <section class="border border-secondary col-md-4 col-sm-4 pt-2 graph">
                <div class="text-center mt-3">
                    Site Efficiency
                </div>
                <div id="site_efficiency_div" class="ml-3">
                    <canvas id="site_efficiency" style="height:370px ; width:100%"></canvas>
                </div>
            </section>
            <section class="border border-secondary col-md-8 col-sm-8 pb-3 pt-2 graph">
                <div class="text-center mt-3">
                    Site Fault Summary
                </div>
                    <div id="site_fault_summary_div" class="position-relative">
                        <canvas id="site_fault_summary" style="height:350px ; width:100%"></canvas>
                    </div>
                    <div class="d-flex justify-content-around  " style="margin-top: -50px;font-size: 17px ">
                        @foreach($forSiteFaultSummaryChart as $key=> $category)
                            <div>
                                <div class="d-flex justify-content-around">
                                    <div class="color-box" style="background-color: {{$category['color']}}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around mt-2">
                                    {{$key}}
                                </div>
                                <div class="d-flex justify-content-around">
                                    {{$category['count']}}
                                </div>
                            </div>
                        @endforeach
                    </div>
            </section>
        </div>
            <div class="row mt-3">
                <section class="border border-secondary d-flex col-sm-12 col-md-12 pb-3 pt-2 graph">
                    <div class="col-md-4 col-sm-4">
                        <div class="text-center mt-3">
                            Total Faults per MW
                        </div>
                        <div id="faults_per_mw_div" class="ml-3 ">
                            <canvas id="faults_per_mw" style="height:370px ; width:100%"></canvas>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-8 ml-4 ml-5">
                        <div class="text-center mt-2 ">Faults per MW</div>
                        <div class="d-flex align-items-end flex-wrap justify-content-around justify-content-start mt-5">
                            @foreach($forTotalFaultsPerMW as $key=> $item)
                                <div class="col-sm-3 col-md-3 d-flex flex-column mt-3 ">
                                    <div class="align-self-center">
                                        {{$key}}
                                    </div>
                                    <div class="align-self-center" style="color:{{$item['color']}};  margin-top: -15px">
                                        <u class="font-weight-bold" style="font-size: 40px;">{{$item['countPerMw']}}</u>
                                    </div>
                                    <div class="align-self-center" style="color:{{$item['color']}};  margin-top: -15px">MW</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>

            <div class="row mt-3">
                <section class="border border-secondary col-sm-12 col-md-12">
                    <div class="text-center mt-5 graph">Substation Defect Summary</div>
                    <table class="table mt-5" id="substation_defect_summary">
                        <th scope="col"></th>
                        @foreach($faultsCategories as $category)
                            <th scope="col" data-color="{{$category->color}}" class="text-left">{{$category->name}}</th>
                        @endforeach
                        <th scope="col" class="text-left">Totals</th>
                        @foreach($substationDefectSummary as $substation)
                            <tr>
                            @if(!$loop->last)
                                @foreach($substation as $item)
                                    @if ($loop->first)
                                        <th scope="row" class="text-center">Substation {{$item}}</th>
                                    @elseif($loop->last)
                                        <th scope="row" class="text-center">{{$item}}</th>
                                    @else
                                        <td class="text-center">{{$item}}</td>
                                    @endif
                                @endforeach

                            @else
                                @foreach($substation as $item)
                                    <th scope="row" class="text-center" >{{$item}}</th>
                                @endforeach
                            @endif
                            </tr>
                        @endforeach
                    </table>
                </section>
            </div>
            @if(!empty($forHotSpotDefectsChart))
                <div class="row mt-3 d-flex">
                    <section class="border border-secondary col-md-4 col-sm-4 pt-2 pb-3 graph">
                        <div class="text-center mt-2 ">Total Hotspot Defects</div>
                        <div id="hotspots_defects_div" class="ml-3">
                            <canvas id="hotspots_defects" style="height:370px ; width:100%"></canvas>
                        </div>
                    </section>
                    <section class="border border-secondary col-md-8 col-sm-8 pb-3 pt-2 graph">
                        <div class="text-center mt-2 mb-3">Possible Causes of Hotspot</div>
                        <div id="causes_of_hotspot_div">
                            <canvas id="causes_of_hotspot" style="height:350px ; width:100%"></canvas>
                        </div>
                    </section>
                </div>
            @endif
        @if(!empty($hotSpotSummary))
            <div class="row mt-3">
                <section class="border border-secondary col-sm-12 col-md-12">
                    <div class="text-center mt-5 graph">Substation Hotspot Summary</div>
                    <table class="table mt-5" id="substation_hotspot_summary">
                        <th scope="col"></th>
                        @foreach($forHotSpotDefectsChart as $key=>$value)
                            <th scope="col" class="text-center">{{$key}}</th>
                        @endforeach
                        <th scope="col" class="text-center">Totals</th>
                        @foreach($hotSpotSummary as $substation)
                            <tr>
                                    @foreach($substation as $item)
                                        @if ($loop->first)
                                            <th scope="row" class="text-center">Substation {{$item}}</th>
                                        @elseif($loop->last)
                                            <th scope="row" class="text-center">{{$item}}</th>
                                        @else
                                            <td class="text-center">{{$item}}</td>
                                        @endif
                                    @endforeach
                            </tr>
                        @endforeach
                        <th scope="row" class="text-center">Overall Totals</th>
                        @foreach($forHotSpotDefectsChart as $item)
                            <th scope="row" class="text-center" >{{$item['count']}}</th>
                        @endforeach
                        <th scope="row" class="text-center">{{$project->faults->where('fault_id','Hotspot')->count()}}</th>
                    </table>
                </section>
            </div>
        @endif

        @if(!empty($forPIDDefectsChart))
            <div class="row mt-3 d-flex">
                <section class="border border-secondary col-md-4 col-sm-4 pt-2 pb-3 graph">
                    <div class="text-center mt-2 ">Total PID Defects</div>
                    <div id="PID_defects_div" class="ml-3">
                        <canvas id="PID_defects" style="height:370px ; width:100%"></canvas>
                    </div>
                </section>
                <section class="border border-secondary col-md-8 col-sm-8 pb-3 pt-2 graph">
                    <div class="text-center mt-2 mb-3">PID Severity Levels</div>
                    <div id="PID_severity_levels_div">
                        <canvas id="PID_severity_levels" style="height:350px ; width:100%"></canvas>
                    </div>
                </section>
            </div>
        @endif
        @if(!empty($pidSummary))
            <div class="row mt-3">
                <section class="border border-secondary col-sm-12 col-md-12">
                    <div class="text-center mt-5 graph">Substation PID Summary</div>
                    <table class="table mt-5" id="substation_pid_summary">
                        <th scope="col"></th>
                        @foreach($forPIDDefectsChart as $key=>$value)
                            <th scope="col" class="text-center">{{$key}}</th>
                        @endforeach
                        <th scope="col" class="text-center">Totals</th>
                        @foreach($pidSummary as $substation)
                            <tr>
                                @foreach($substation as $item)
                                    @if ($loop->first)
                                        <th scope="row" class="text-center">Substation {{$item}}</th>
                                    @elseif($loop->last)
                                        <th scope="row" class="text-center">{{$item}}</th>
                                    @else
                                        <td class="text-center">{{$item}}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        <th scope="row" class="text-center">Overall Totals</th>
                        @foreach($forPIDDefectsChart as $item)
                            <th scope="row" class="text-center" >{{$item['count']}}</th>
                        @endforeach
                        <th scope="row" class="text-center">{{$project->faults->where('fault_id','PID')->count()}}</th>
                    </table>
                </section>
            </div>
        @endif
    </div>
</div>


<script>

    //site efficiency chart
    new Chart(document.getElementById("site_efficiency"), {
         plugins: [{

             beforeDraw: function(chart) {
                 var width = chart.chart.width,
                     height = chart.chart.height,
                     ctx = chart.chart.ctx;

                 ctx.restore();
                 var fontSize = (height / 110).toFixed(2);
                 ctx.font = fontSize + "em sans-serif";
                 ctx.textBaseline = "middle";

                 var text = "{{$forSiteEfficiencyChart['efficiency']}}%",
                     textX = Math.round((width - ctx.measureText(text).width) / 2),
                     textY = height / 2;

                 ctx.fillText(text, textX, textY);
                 ctx.save();
             }
         },{
             beforeDraw: function(chart) {
                 var width = chart.chart.width,
                     height = chart.chart.height,
                     ctx = chart.chart.ctx;

                 ctx.restore();
                 var fontSize = (height / 380).toFixed(2);
                 ctx.font = fontSize + "em sans-serif";
                 ctx.textBaseline = "middle";

                 var text = "Efficient",
                     textX = Math.round((width - ctx.measureText(text).width) / 2),
                     textY = (height*10)/ 16;

                 ctx.fillText(text, textX, textY);
                 ctx.save();
             }
         }
         ],
        type: 'doughnut',
        data: {
            datasets: [
                {
                    backgroundColor: ["#32CD32", "#FF0000"],
                    data: [{{$forSiteEfficiencyChart['efficiency']}},{{$forSiteEfficiencyChart['incapacity']}}]
                }
            ]
        },
        options: {
            cutoutPercentage:80,
            legend: {
                display: false
            },
            tooltips: {
                enabled: false,
            },

        }
    });

    //Site fault summary chart
    new Chart(document.getElementById("site_fault_summary"), {
        type: 'horizontalBar',
        data: {
            labels:["{{$project->project_name}}"],

            datasets: [
                    @foreach($forSiteFaultSummaryChart as $key=> $item)
                {
                    label: '{{$key}}',
                    data: [
                        {{$item['count']}},
                    ],
                    backgroundColor:
                        "{{$item['color']}}",
                },
                @endforeach
            ]
        },
        options: {
            legend: {
                display: false
            },
            tooltips: {
                enabled: true,
                mode: 'nearest'
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    display:false,
                }],
                yAxes: [{
                    stacked: true,
                    display:false,
                    barPercentage: 0.3
                }]
            },
            layout: {
                padding: {
                    left: 50,
                }
            }


        }
    });
    var faultsSummary = document.createElement("p");
    faultsSummary.innerHTML = "{!! '<strong>'.$project->faults->count().'</strong>'  !!}" + ' '+'total defects';
    document.getElementById("site_fault_summary_div").appendChild(faultsSummary);
    faultsSummary.style.cssText = 'position:absolute; top:15%; left:42%; font-size:20px';


   //Faults per MW chart
    new Chart(document.getElementById("faults_per_mw"), {
        plugins: [{
            beforeDraw: function(chart) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = (height / 100).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = "{{number_format($project->faults->count()/$project->total_dc_capacity_mw, 1, '.', '')}}",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        },{
            beforeDraw: function(chart) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = (height / 350).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = "MW",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = (height*10)/ 16;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
        ],
        type: 'doughnut',
        data: {
            labels:["{{$project->project_name}}"],

            datasets: [

                {
                    data: [
                        @foreach($forTotalFaultsPerMW as $item)
                        {{$item['countPerMw']}},
                        @endforeach
                    ],
                    backgroundColor:[
                        @foreach($forTotalFaultsPerMW as $item)
                        "{{$item['color']}}",
                        @endforeach
                    ]

                },
            ]
        },
        options: {
            cutoutPercentage:80,

            legend: {
                display: false
            },
            tooltips: {
                enabled: false,
            },

        }
    });

    @if(!empty($forHotSpotDefectsChart))

    //Start hotspots defects chart
        new Chart(document.getElementById("hotspots_defects"), {
            plugins: [{
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = (height / 90).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "{{$forHotSpotDefectsChart['Vegetation']['color']?? '#b3174b'}}";

                    var text = "{{$project->faults->where('fault_id','Hotspot')->count()}}",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            },{
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = (height / 380).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "{{$forHotSpotDefectsChart['Vegetation']['color'] ?? '#b3174b'}}";

                    var text = "Hotspots",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = (height*10)/ 16;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }],
            type: 'doughnut',
            data: {
                labels:["{{$project->project_name}}"],

                datasets: [

                    {
                        data: [
                            @foreach($forHotSpotDefectsChart as $item)
                            {{$item['count']}},
                            @endforeach
                        ],
                        backgroundColor:[
                            @foreach($forHotSpotDefectsChart as $item)
                                "{{$item['color']}}",
                            @endforeach
                        ]
                    },
                ]
            },
            options: {
                cutoutPercentage:80,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false,
                },
            }
        });
    //END hotspots defects chart


    /*Start Possible Causes of Hotspot chart*/
        new Chart(document.getElementById("causes_of_hotspot"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($forHotSpotDefectsChart as $key=>$value)
                        "{{$key}}",
                    @endforeach
                ],
                datasets: [
                    {
                        backgroundColor: [
                            @foreach($forHotSpotDefectsChart as $key=>$causes)
                                "{{$causes['color']}}",
                            @endforeach
                        ],
                        data: [
                            @foreach($forHotSpotDefectsChart as $key=>$causes)
                                {{$causes['count']}},
                            @endforeach
                        ]
                    }
                ]
            },
            options: {

                legend:{
                    display:false,
                    labels: {
                        fontSize:20,
                        boxWidth:15,
                        fontColor: 'black'
                    }
                },

                    tooltips: {
                        enabled: false,
                        mode: 'nearest'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                fontFamily: "Century Gothic",

                                fontSize:18,
                                fontColor: 'black',
                            },
                        }],
                        yAxes: [{
                            stacked: true,
                            display: false,
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    animation: {
                        "onComplete": function () {
                            var chartInstance = this.chart,
                                ctx = chartInstance.ctx;

                            ctx.font = Chart.helpers.fontString(18, '', Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function (bar, index) {
                                    var data = dataset.data[index];
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    }
                }
        });
    /*End Possible Causes of Hotspot chart*/

    @endif

    @if(!empty($forPIDDefectsChart))
    /*Start Total PID Defects*/
        new Chart(document.getElementById("PID_defects"), {
            plugins: [{
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = (height / 90).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "{{$forPIDDefectsChart['Severe']['color'] ?? '#3366cc'}}";

                    var text = "{{$project->faults->where('fault_id','PID')->count()}}",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            },
                {
                    beforeDraw: function(chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 380).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "{{$forPIDDefectsChart['Severe']['color'] ?? '#3366cc'}}";

                        var text = "Pid Defects",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = (height*10)/ 16;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            ],
            type: 'doughnut',
            data: {
                labels:["{{$project->project_name}}"],

                datasets: [
                    {
                        data: [
                            @foreach($forPIDDefectsChart as $item)
                            {{$item['count']}},
                            @endforeach
                        ],
                        backgroundColor:[
                            @foreach($forPIDDefectsChart as $item)
                                "{{$item['color']}}",
                            @endforeach
                        ]
                    },
                ]
            },
            options: {
                cutoutPercentage:80,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false,
                },

            }
        });
    /*End Total PID Defects*/


    /*Start PID Severity Levels*/
        new Chart(document.getElementById("PID_severity_levels"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($forPIDDefectsChart as $key=>$value)
                        "{{$key}}",
                    @endforeach
                ],
                datasets: [
                    {
                        backgroundColor: [
                            @foreach($forPIDDefectsChart as $key=>$causes)
                                "{{$causes['color']}}",
                            @endforeach
                        ],
                        data: [
                            @foreach($forPIDDefectsChart as $key=>$causes)
                            {{$causes['count']}},
                            @endforeach
                        ]
                    }
                ]
            },
            options: {
                legend:{
                    display:false,
                    labels: {
                        fontSize:20,
                        boxWidth:15,
                        fontColor: 'black'
                    }
                },

                tooltips: {
                    enabled: false,
                    mode: 'nearest'
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            fontFamily: "Century Gothic",

                            fontSize:18,
                            fontColor: 'black',
                        },
                    }],
                    yAxes: [{
                        stacked: true,
                        display: false,
                        gridLines: {
                            display: false
                        }
                    }]
                },
                animation: {
                    "onComplete": function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(18, '', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                }
            }
        });
    /*End PID Severity Levels*/
    @endif

</script>



