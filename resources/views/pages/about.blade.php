@extends('layouts.app')

@section('pageTitle', 'About')

@section('content')
    <p>Hello there big boy</p>

    @if(count($array) > 0)
        <ul>
            @foreach($array as $value)
                <li>{{$value}}</li>
            @endforeach
        </ul>
    @endif
@endsection