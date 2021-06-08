<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    @if(isset($controller) && isset($action) && $controller =='ProjectController' && $action == 'map' )
        <link href='https://api.mapbox.com/mapbox.js/v3.3.0/mapbox.css' rel='stylesheet' />
    @endif
    @yield('css')

    <title>@yield('title') eco.ems</title>
    <link rel="icon" href="{{asset('logo/title.jpg')}}"/>



    @if(isset($controller) && isset($action) && $controller =='ProjectController' && $action == 'map' )
        <script src="{{asset('js/mapbox/mapbox.js')}}"></script>
    @endif


    @if((isset($controller) && isset($action) && $controller =='ProjectController' && $action == 'analytics') || (isset($controller) && isset($action) && $controller =='ProfileController' && $action == 'projects'))
        <script src="{{asset('js/charts/chart.js')}}"></script>
    @endif
    <script src="{{asset('js/app.js')}}"></script>

    <script src="{{asset('js/myScripts.js')}}"></script>


</head>
<body class="tundra">
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-8">
                <a href="{{ route('profile.index') }}" style="display: flex; text-decoration: none">
                    <img src="{{asset('logo/logo.png')}}" alt="logo" class="img-fluid logo" >
                    <div class="solr solr1">solar portal</div>
                </a>
            </div>
            @auth
                <div class="col-md-5 col-sm-5 col-xs-12 hidden-xs clientnme">
                    <h5>Welcome, {{ Auth::user()->name }}</h5>
                </div>
            @endauth

            <div class="col-md-1 col-sm-1 col-xs-4 @guest offset-5 @endguest ">
                <button class="nvbutton" onclick="openNav()">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </button>
            </div>
            <div id="mySidenav" class="sidenav" >
                <a href="#" id="closebtn" class="closebtn sidenavv" onclick="closeNav()">x</a>
                @auth()
                    <h5><a href="">Profile</a></h5>
                    <h5><a href="{{ route('changePasswordForm') }}">Change password</a></h5>
                    <h5><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     sessionStorage.clear();
                                                     document.getElementById('logout-form').submit();">
                            Log out</a></h5>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth

                @guest()
                    <h5><a href="{{route('index')}}">Log In</a></h5>
                @endguest
            </div>
        </div>
    </div>
</div>

{{--Start content--}}
@yield('content')
{{--End content--}}

<div class="foot">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li ><a href="#" class="text-white">About Us</a></li>
                    <li><a href="#" class="text-white">Contact Us</a></li>
                    <li><a href="#" class="text-white">Terms of Use</a></li>
                    <li><a href="#" class="text-white">Privacy Policy</a></li>
                </ul>
            </div>
            <div style="width: 100%">
                <hr style="border: 1.5px solid white;">
            </div>

            <div class=" col-md-12 d-flex justify-content-around">
                <div class="col-md-6 col-xs-6 col-sm-6">
                    <h5 class="text-white">Copyright © 2020&nbsp;eco.ems. All Rights Reserved</h5>
                </div>
                <div class="col-md-6 hidden-xs col-sm-6">
                    <a href="{{ route('profile.index') }}"><img src="{{asset('logo/logo.png')}}" class="img-responsive logo float-right mb-5"></a>
                </div>
            </div>

        </div>
    </div>
</div>

@yield('js')

<script>
{{--    nabvar logic--}}
function openNav() {
    let sideNav = document.getElementById('mySidenav');
    sideNav.setAttribute("style","width:340px");
    let closebtn = document.getElementById('closebtn');
    closebtn.style.display = "block";
}
function closeNav() {
    let sideNav = document.getElementById('mySidenav');
    sideNav.setAttribute("style","width:0");
    let closebtn = document.getElementById('closebtn');
    closebtn.style.display = "none";
}
{{--  end  nabvar logic--}}

</script>
</body>
</html>
