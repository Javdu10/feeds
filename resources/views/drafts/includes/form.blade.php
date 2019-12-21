@csrf
<div class="form-group">
<input type="text" class="form-control" name="title" value="{{ old('title') ?? $draft->title }}">
    <input type="text" class="form-control" name="heading" value="{{ old('heading') ?? $draft->heading }}">
    <input type="text" class="form-control" name="body" value="{{ old('body') ?? $draft->body }}">
</div>