@extends('layouts.app')

@section('content')
    <form action="/drafts/{{$draft->id }}" method="post">
        @method('PATCH')
        @include('drafts.includes.form')
        <button class ="btn btn-primary">Enregistrer</button>
    </form>
    <form action="/drafts/{{$draft->id }}/delete" method="post">
        @csrf
        @method('DELETE')
        <button class ="btn btn-primary">Supprimer</button>
    </form>
@endsection
