@extends('layouts.app')

@section('content')
    <form id="form-editor" action="/drafts" method="post">
        @include('drafts.includes.form')
        <button class ="btn btn-primary">Créer</button>
    </form>
@endsection