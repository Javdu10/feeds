@extends('layouts.app')

@section('content')
    <div class="page-header">
        <a href="/drafts/create" class="btn btn-primary float-right">
        <span class="glyphicon glyphicon-pencil"></span> Write Article
        </a>
        <a href="/drafts/" class="btn btn-secondary float-right" style="margin-right: .8em">Drafts</a>
        <h1>Articles</h1>
    </div>
    <div class="row">
        <div class="col-md-9">
            <section>
                @foreach ($articles as $item)
                    <article>
                        <h2>
                            <div class="row">
                                <div class="col-md-5">
                                    <a href="/articles/test-test-test/">test test test</a>
                                </div>
                                <div class="col-md-7" style="align-self: center;text-align: center;font-size: 0.5em;">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>           
                                    </div>
                                    1000 votes
                                </div>
                            </div>
                            
                        </h2>
                        <div class="info">
                        <span class="date">
                            <span class="glyphicon glyphicon-calendar"></span>
                            Dec. 21, 2019, 9:55 a.m.
                        </span>
                        
                        </div>
                        <div class="content">
                            
                                <p><strong>test</strong>
                    <em>afasffasdf</em></p>
                            
                        </div>
                        
                        <div class="tags">
                            
                            <a href="/articles/tag/Test/"><span class="label label-default">Test</span></a>
                            
                            <a href="/articles/tag/hello/"><span class="label label-default">hello</span></a>
                            
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