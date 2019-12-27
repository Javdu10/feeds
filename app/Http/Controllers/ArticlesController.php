<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Report;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest())
            $articles = Article::all();
        else $articles = Article::withAnyTag(Auth::user()->tagNames)->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if(Auth::id() !== $article->user->id)
            return redirect('/')->with('error-message', 'Vous ne pouvez pas supprimer cet article.');

        $article->delete();
        return redirect('/')->with('success-message', 'Article supprimé.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function like(Article $article)
    {
        if($article->user->id === Auth::id())
            return redirect('articles/'.$article->id)->with('error-action', "Vous ne pouvez pas voter pour vos articles !");

        $vote = Vote::firstOrNew(['user_id'=>Auth::id(), 'article_id'=>$article->id]);
        if($vote->vote !== 'for'){
            if($vote->vote === 'against'){
                $article->votes_for++;
                $article->votes_against--;
                $vote->vote = 'for';
            }else if($vote->vote === null){ // new vote
                $article->votes_for++;
                $vote->vote = 'for';
            }
            $vote->save();
            $article->save();
        }

        return redirect('articles/'.$article->id)->with('success-action', "Votre avis a été pris en compte !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function dislike(Article $article)
    {
        if($article->user->id === Auth::id())
            return redirect('articles/'.$article->id)->with('error-action', "Vous ne pouvez pas voter pour vos articles !");

        $vote = Vote::firstOrNew(['user_id'=>Auth::id(), 'article_id'=>$article->id]);
        if($vote->vote !== 'against'){
            if($vote->vote === 'for'){
                $article->votes_for--;
                $article->votes_against++;
                $vote->vote = 'against';
            }else if($vote->vote === null){ // new vote
                $article->votes_against++;
                $vote->vote = 'against';
            }
            $vote->save();
            $article->save();
        }

        return redirect('articles/'.$article->id)->with('success-action', "Votre avis a été pris en compte !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function report(Article $article)
    {
        if($article->user->id === Auth::id())
            return redirect('articles/'.$article->id)->with('error-action', "Vous ne pouvez pas signaler vos articles !");

        $report = Report::firstOrNew(['user_id'=>Auth::id(), 'article_id'=>$article->id]);
        
        if($report->reason === null){ // new report
            $article->reports++;
            $report->reason = request('reason') ?? 'suspect_or_spam';
            $article->save();
        }else{
            $report->reason = request('reason') ?? 'suspect_or_spam';
        }
            
        $report->save();

        return redirect('articles/'.$article->id)->with('success-action', "Signalement pris en compte !");
    }


}
