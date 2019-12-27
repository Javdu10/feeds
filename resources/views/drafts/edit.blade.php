@extends('layouts.app')

@section('content')
    @if(session()->has('error-publish'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error-publish')}}
        </div>
    @endif
    <form id="form-editor" action="/drafts/{{$draft->id }}" method="post">
        @method('PATCH')
        @csrf
        <div class="form-group">
        <input type="text" class="form-control" name="title" value="{{ old('title') ?? $draft->title }}">
        <input type="text" class="form-control" name="heading" value="{{ old('heading') ?? $draft->heading }}">
        <input type="text" class="form-control" data-role="tagsinput" name="tags" value="{{ old('tags') ?? implode(',',$draft->tagNames()) }}">
            <div id="toolbar-container"></div>

            <!-- This container will become the editable. -->
            <div class="document-editor">
                <div class="document-editor__toolbar"></div>
                <div class="document-editor__editable-container">
                    <textarea name="body" class="document-editor__editable">
                        {{ old('body') ?? html_entity_decode($draft->body ) }}
                    </textarea>
                    
                </div>
            </div>
            <div id="snippet-autosave-header">
                <div id="snippet-autosave-status" class="busy">
                    <div id="snippet-autosave-status_label">Status:</div>
                    <div id="snippet-autosave-status_spinner">
                        <span id="snippet-autosave-status_spinner-label"></span>
                        <span id="snippet-autosave-status_spinner-loader" class="text-danger spinner-border"></span>
                    </div>
                </div>
                <div id="word-count"></div>
            </div>
        </div>
    </form>
    <form action="/drafts/{{$draft->id }}/delete" method="post">
        @csrf
        @method('DELETE')
        <button class ="btn btn-danger">Supprimer</button>
    </form>
    <form action="/drafts/{{$draft->id }}/publish" method="post">
        @csrf
        <button class ="btn btn-warning">Publier</button>
    </form>
@endsection
