@extends('layouts.app')

@section('content')
    <div class="page-header">
        <a href="/drafts/create" class="btn btn-primary float-right">
        <span class="glyphicon glyphicon-pencil"></span> Write Article
        </a>
        <a href="/drafts/" class="btn btn-secondary float-right" style="margin-right: .8em">Drafts</a>
        <h1>Articles</h1>
        @if(session()->has('error-message'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error-message')}}
            </div>
        @endif
        @if(session()->has('success-message'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success-message')}}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-9">
            <section>
                
                @if(count($articles) === 0)
                <div class="alert alert-warning" role="alert">
                    Pensez à modifier vos préférences <a class="btn btn-success" href="/users/{{ Auth::user()->id }}">en cliquant ici</a>
                </div>
                @endif
                @foreach ($articles as $item)
                    @php
                        $votes_count = $item->votes_for + $item->votes_against;
                        if($votes_count !== 0){
                            $percent_for = number_format(($item->votes_for / $votes_count ) * 100, 2);
                            $percent_against = number_format(($item->votes_against / $votes_count ) * 100, 2); 
                        }else{
                            $percent_for = 0;
                            $percent_against = 0;
                        }
                                               
                    @endphp
                    <article>
                        <h2>
                            <div class="row">
                                <div class="col-md-5">
                                    <a href="/articles/{{ $item->id }}">{{ $item->title }}</a>
                                </div>
                                <div class="col-md-7" style="align-self: center;text-align: center;font-size: 0.5em;">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent_for }}%" aria-valuenow="{{ $percent_for }}" aria-valuemin="0" aria-valuemax="100">{{ $percent_for }}%</div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percent_against }}%" aria-valuenow="{{$percent_against}}" aria-valuemin="0" aria-valuemax="100">{{$percent_against}}%</div>           
                                    </div>
                                    {{ $votes_count }}
                                    @if ($votes_count < 2 )
                                        vote
                                    @else
                                        votes
                                    @endif                                   
                                </div>
                            </div>
                            
                        </h2>
                        <div class="info">
                        <span class="date">
                            <span class="glyphicon glyphicon-calendar"></span>
                            {{ $item->created_at }}
                        </span>
                        
                        </div>
                        <div class="content">
                            {{ $item->heading }}
                        </div>
                        
                        <div class="tags">
                            @foreach ($item->tags as $tag)
                                <span class="badge badge-secondary">{{$tag->name}}</span>
                            @endforeach
                        </div>
                        
                    </article>
                @endforeach
            </section>
        </div>
        <div class="col-md-3">
            <form class="form-inline my-2 my-lg-0">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                    </div>
                  </div>
              </form>
              Tags
        </div>
    </div>
   
@endsection