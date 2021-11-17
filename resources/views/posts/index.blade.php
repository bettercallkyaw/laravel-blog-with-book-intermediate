@extends('layouts.app')

@section('title','all posts')

@section('content')
<div class="container">

    @if (Session::has('status'))
        <div class="alert alert-danger">
            {{ Session::get('status') }}
        </div>
    @endif
   
    @if (Session::has('successMsg'))
        <div class="alert alert-success">
            {{ Session::get('successMsg') }}
        </div>
    @endif

    @foreach($posts as $post)
         <div class="card mb-2">
             <div class="card-body">
 
                <img src="{{ asset('storage/posts/'.$post->image) }}"  alt="" height="300" width="300">
 
                 <h5 class="card-title">{{ $post->title }}</h5>
                 <div class="card-subtitle mb-2 text-muted small">
                     {{ $post->created_at->diffForHumans() }}
                 </div>
                 <p class="card-text">{{ Str::substr($post->content, 0, 90) }}</p>
                 <a class="card-link" href="{{ route('posts.show',$post->id) }}">
                     View Detail &raquo;
                 </a>
             </div>
         </div>
     @endforeach
     <br>
     {{ $posts->links() }}
 </div>
@endsection