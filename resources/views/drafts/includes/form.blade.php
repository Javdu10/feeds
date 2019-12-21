@csrf
<div class="form-group">
<input type="text" class="form-control" name="title" value="{{ old('title') ?? $draft->title }}">
    <input type="text" class="form-control" name="heading" value="{{ old('heading') ?? $draft->heading }}">
    <div id="toolbar-container"></div>

    <!-- This container will become the editable. -->
    <div class="document-editor">
        <div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
            <div name="body" class="document-editor__editable">
                {{ old('body') ?? str_replace( '&', '&amp;', $draft->body ) }}
            </div>
            <div id="word-count"></div>
        </div>
    </div>
</div>
