@extends('layouts.app')

@section('content')
@if(session()->has('success-message'))
<div class="alert alert-success" role="alert">
    {{ session()->get('success-message')}}
</div>
@endif
<form id="form-editor" action="/users/{{$user->id }}" method="post">
    @csrf
    @method('PATCH')
    @php
        $array_tag = "";
        if(count($user->tags) > 0){
            foreach ($user->tags as $tag) {
                $array_tag.=",$tag->name";
            }
        }
    @endphp
    <div class="form-group">
        <input type="text" class="form-control" data-role="tagsinput" name="tags" value="{{ old('tags') ?? $array_tag }}">
    </div>
    <button class ="btn btn-success">Enregister</button>
</form>
@endsection