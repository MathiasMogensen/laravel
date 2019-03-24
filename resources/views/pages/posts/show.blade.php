@extends('layouts.app')

@section('pageTitle', $post->title)

@section('content')

    <a href="/posts" class="btn btn-primary">Back</a>
    <br><br>

    @if(!empty($post))
        <h1>{{$post->title}}</h1>
        <img style="width:50%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
        <div>
            {!!$post->body!!}
        </div>
        <hr>
        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
        
        <hr>

        @auth
            @if(Auth::user()->id == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a>

                {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
            @endif
        @endauth

    @else
        <p>Post not found</p>
    @endif

@endsection