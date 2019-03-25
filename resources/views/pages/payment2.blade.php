@extends('layouts.app')

@section('pageTitle', 'G2A Payment')

@section('content')

    <h1>Payment 2</h1>
    <br>

    {{$message}}
    <br><br>

    <a href="/payment2/pay" class="btn btn-default">Pay</a>
        

@endsection