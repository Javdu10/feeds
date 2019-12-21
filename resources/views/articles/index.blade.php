@extends('layouts.app')

@section('content')
    <ul>
        @foreach ($articles as $item)
            <li>{{$item}}</li>
        @endforeach
    </ul>
@endsection