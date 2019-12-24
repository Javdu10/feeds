@extends('layouts.app')

@section('content')
    @if(session()->has('success-action'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success-action')}}
        </div>
    @endif
    <div class="document-editor">
        <div class="document-editor__editable-container">
            <textarea name="body" class="document-editor__editable">
                {{ html_entity_decode($article->body ) }}
            </textarea>
        </div>
    </div>
    <div id="snippet-autosave-header">
        <div id="word-count"></div>
    </div>

    <form action="/articles/{{$article->id }}/like" method="post">
        @csrf
        @method('PATCH')
        <button class ="btn btn-success">Je suis d'accord</button>
    </form>
    <form action="/articles/{{$article->id }}/dislike" method="post">
        @csrf
        @method('PATCH')
        <button class ="btn btn-danger">Je ne suis pas d'accord</button>
    </form>
    
@endsection