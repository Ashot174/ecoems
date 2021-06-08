@extends('layouts.site')
@section('title')
    Page Not Found
@endsection

@section('content')
<div class="container mt-5" >
    <div class="col-md-10 col-sm-10 offset-2" style="background-image: url({{asset('img/404.png')}}); background-size: auto; background-repeat:no-repeat;  height: 400px"></div>
    <div class="error-404-text mt-5 mb-5">
        <p>We are sorry but the page you are looking for does not exist. You could <a href="{{route('profile.index')}}" class="font-weight-bold"> return to home page</a>
        </p>
    </div>
</div>
@endsection
