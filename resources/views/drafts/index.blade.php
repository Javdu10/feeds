@extends('layouts.app')

@section('content')
    @if(session()->has('success-publish'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success-publish') }}
        </div>
    @endif
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Date de création</th>
            <th scope="col">Date de mise à jour</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($drafts as $item)
                <tr>
                    <td>{{ $item->title ?? 'A définir' }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td><a href="/drafts/{{ $item->id }}/edit" class="btn btn-primary">Voir</a></td>
                </tr>
             @endforeach
        </tbody>
    </table>
   
    <a href="/drafts/create" class="btn btn-primary">Create</a>
@endsection