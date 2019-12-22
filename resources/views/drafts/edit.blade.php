@extends('layouts.app')

@section('content')
    <form id="form-editor" action="/drafts/{{$draft->id }}" method="post">
        @method('PATCH')
        @csrf
        <div class="form-group">
        <input type="text" class="form-control" name="title" value="{{ old('title') ?? $draft->title }}">
            <input type="text" class="form-control" name="heading" value="{{ old('heading') ?? $draft->heading }}">
            <div id="toolbar-container"></div>

            <!-- This container will become the editable. -->
            <div class="document-editor">
                <div class="document-editor__toolbar"></div>
                <div class="document-editor__editable-container">
                    <textarea name="body" class="document-editor__editable">
                        {{ old('body') ?? str_replace( '&', '&amp;', $draft->body ) }}
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
        <button class ="btn btn-primary">Enregistrer</button>
    </form>
    <form action="/drafts/{{$draft->id }}/delete" method="post">
        @csrf
        @method('DELETE')
        <button class ="btn btn-primary">Supprimer</button>
    </form>
@endsection
