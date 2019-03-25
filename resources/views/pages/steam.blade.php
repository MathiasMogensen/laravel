@extends('layouts.app')

@section('pageTitle', 'Steam')

@section('content')

    <h1>Steam</h1>
    <br>

        @if(!empty(session('steamid')))
            <p>Logged in as: {{session('steamName')}} ({{session('steamid')}})</p>
            <a class="btn btn-danger" href="/steam/logout">Logout</a>
        @else
            <a class="btn btn-primary" href="/steam/login">Login</a>
        @endif
        

@endsection