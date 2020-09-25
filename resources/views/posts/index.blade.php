@extends('layouts.app')

@section('content')
<div class="container">

    @foreach($posts as $post)    
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/profile/{{ $post->user->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>                
            </div>
        </div>

        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>           
                    <p>                         
                        <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark font-weight-bold">{{ $post->user->username }}</span>
                        </a>                       
                        {{ $post->caption }} 
                        @foreach($post->comments as $comment)    
                            <p>
                                <a href="/profile/{{ $comment->user->id }}">
                                    <span class="text-dark font-weight-bold">{{ $comment->user->username }}</span>
                                </a>
                                {{ $comment->comment }}
                            </p> 
                        @endforeach          
                    </p>
                </div>
                <form action="/comment/{{ $post->id }}" method="post">
                    @csrf
                    <textarea name="comment" cols="30" rows="2" placeholder="Add Comment..."></textarea>
                    <button>Share</button>
                </form>
            </div>
        </div> 
    @endforeach  

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links("pagination::bootstrap-4") }}
            </div>
        </div>

</div>

@endsection
