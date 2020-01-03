@extends('layouts.app')

@section('content')
    @if(session()->has('success-action'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success-action')}}
        </div>
    @endif
    @if(session()->has('error-action'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error-action')}}
        </div>
    @endif
    @php
        echo $ins;
    @endphp
    <div class="document-editor">
        <div class="document-editor__editable-container">
            <textarea name="body" class="document-editor__editable">
                {{ html_entity_decode($del ) }}
            </textarea>
        </div>
    </div>
    <div id="snippet-autosave-header">
        <div id="word-count"></div>
    </div>
    

    @if(Auth::id() === $article->owner_id)
        <button data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger">Supprimer</button>
        <div class="modal fade" id="confirm-delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Supprimer l'article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <p>Vous aller supprimer un article, cette action est iréversible.</p>
                        <p>Etes-vous sûr ?</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <form action="/articles/{{ $article->id }}/delete" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class ="btn btn-danger">Supprimer</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    
    @else
        <form action="/articles/{{$article->id }}/like" method="post">
            @csrf
            @method('PATCH')
            <button class ="btn btn-success">Je suis d'accord</button>
        </form>
        <form action="/articles/{{$article->id }}/dislike" method="post">
            @csrf
            @method('PATCH')
            <button class ="btn btn-danger">Je ne suis pas d'accord</button>
        </form>
        <button data-toggle="modal" data-target="#confirm-report" class="btn btn-warning" >Signaler l'article</button>
    
        <div class="modal fade" id="confirm-report" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel-report" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel-report">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="/articles/{{ $article->id }}/report" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">En quoi cet article pose-t-il problème ?</label>
                                <select name="reason" class="form-control" id="exampleFormControlSelect1">
                                    <option value="suspect_or_spam">Il est suspect ou publie du spam.</option>
                                    <option value="inapropriate_or_dangerous">Les propos tenus sont inappropriés ou dangereux.</option>
                                    <option value="misleading_about_elections">Il induit en erreur au sujet d'élections.</option>
                                    <option value="suicidal_or_self-destructive">Il exprime des intentions suicidaires ou autodestructrices.</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>            
                            <button type="submit" class ="btn btn-success">Signaler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    
@endsection