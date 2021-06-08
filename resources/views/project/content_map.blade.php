<script src='{{asset('js/leaflet-omnivore.min.js')}}'></script>

<div class="container-fluid" style="width: 100%; background: #efefef">
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
    <div class="container">
        <div class="row mt-5 d-flex justify-content-center navbar align-items-start">
            <div class="col-sm-2 col-md-2 text-center ">
                <a href="{{ route('project.analytics',['id'=>$project->id]) }}" class="nav-link text-dark">Analytics</a>
            </div>
            <div class="col-sm-2 col-md-2 text-center">
                <a href="{{ route('project.map',['id'=>$project->id]) }}" class="nav-link text-dark">Map</a>
                <hr class="hrStyle">
            </div>
            <div class="col-sm-2 col-md-2 text-center">
                <a href="{{route('project.database',['id'=>$project->id])}}" class="nav-link text-dark">Database</a>
            </div>
        </div>
    </div>
    <div class="row mb-4 mt-5" style="position: relative">
        <div id="map"></div>
        <div id="loader"><!-- Place at bottom of page --></div>
    </div>
</div>

@php
  $url = asset(str_replace(' ','','/storage/companies/'.$project->company->name.'/'.$project->project_name.$project->id.'/'));
@endphp
<script>
    var baseURl = '{{asset('storage/')}}'
    var baseURlItem = '{{$url}}'+'/Thermal Images/';
    L.mapbox.accessToken = 'pk.eyJ1IjoiaHJhY2gyMDIwIiwiYSI6ImNrOWwweHV4aDAwZTMzb3MxczQ5aGowYzgifQ._wg6Lc9lmNdQaXi19v06wg';
    var faultsArray = @json($faultsArray);
    var layersDefault = @json($fault_categories);
    var overlayMaps = {};

    var map = L.mapbox.map('map')
        .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));

    // omnivore will AJAX-request this file behind the scenes and parse it:
    // note that there are considerations:
    // - The file must either be on the same domain as the page that requests it,
    //   or both the server it is requested from and the user's browser must
    //   support CORS.

    // Internally this uses the toGeoJSON library to decode the KML file
    // into GeoJSON
    var runLayer = omnivore.kml('{{asset(str_replace(' ','','storage/companies/'.$project->company->name.'/'.$project->project_name.$project->id.'/kmlFile.kml'))}}')
        .on('ready', function() {
            this.setStyle({color: "#808080", weight: 0.6})
            map.fitBounds(runLayer.getBounds());
            document.getElementById("loader").style.display = "none";

            const urlParams = new URLSearchParams(location.search);
            let lat = urlParams.get('lat');
            let long = urlParams.get('long');
            let color = urlParams.get('color');
            let faultId = urlParams.get('faultId');
            let string = urlParams.get('string');
            let module = urlParams.get('module');
            let thermal_image = urlParams.get('thermal');

            let imgUrl = baseURlItem+thermal_image+".jpg"

            if(typeof lat !==undefined && lat !== null && long!==null && typeof long!==undefined){
                var circle = L.circle([lat, long], {
                    color: color,
                    fillColor: color,
                    fillOpacity: 1,
                    radius: 5
                }).addTo(map);
                circle.bindPopup('<div style="display:flex">'+
                    '<div><img src = "'+imgUrl+'" style="width:170px;transform: rotate(180deg)"></div>'+
                    '<div class="ml-1 mt-3">' +
                    '<div>'+faultId+'</div>' +
                    '<div>String: '+string+'</div>' +
                    '<div>Module: '+module+'</div>' +
                    '</div>'+
                    '<div>',

                ).openPopup();
            }

            runLayer.eachLayer(function(layer) {
                 if(layer instanceof L.Marker){
                     layer._icon.src = '';
                     layer._shadow.src = '';
                 }
                });
                }).addTo(map);

    var faultsArrayLen = faultsArray.length;
    var faultArrayCollection = {};
    var checkAll = [];
     for (var i = 0; i < faultsArrayLen ; i++){
         var current = faultsArray[i];
         var image = baseURlItem+current['thermal_image_name']+".jpg";

         var item = L.circle([current['lat'], current['long']], {
             color: current['color'],
             fillColor: current['color'],
             fillOpacity: 1,
             radius: 5
         }).bindPopup('<div style="display:flex">'+
             '<div><img src = "'+image+'" style="width:170px;transform: rotate(180deg)"></div>'+
             '<div class="ml-1 mt-3">' +
             '<div>'+current['fault_id']+'</div>' +
             '<div>String: '+current['string_number']+'</div>' +
             '<div>Module: '+current['module']+'</div>' +
             '</div>'+
             '<div>',
         );

         var layerDefaultIndex = layersDefault.indexOf(current['fault_id']);
         if(layerDefaultIndex>-1){
             if(!faultArrayCollection[layersDefault[layerDefaultIndex]]){
                 faultArrayCollection[layersDefault[layerDefaultIndex]] = [];
             }
             faultArrayCollection[layersDefault[layerDefaultIndex]].push(item)
         }
         checkAll.push(item);

     }

     for(var k in faultArrayCollection){
       var newLayerGroupObj =  L.layerGroup(faultArrayCollection[k]);
         overlayMaps[k] =  newLayerGroupObj;

     }
     overlayMaps['All faults'] = L.layerGroup(checkAll)

    var baseMap = {
         'Fault Categories':runLayer
    }

    L.control.layers(baseMap, overlayMaps,{collapsed: false,position:'topleft'}).addTo(map);



</script>





