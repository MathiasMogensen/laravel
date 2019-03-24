@extends('layouts.app')

@section('pageTitle', 'Posts')

@section('content')

    <a class="btn btn-primary float-right" href="/posts/create">Create Post</a>
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card p-3">
                <div class="row">
                    <div class="col-md-4">
                    <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts</p>
    @endif

@endsection