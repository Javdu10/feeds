<?php

namespace App\Http\Controllers;

use App\Vote;
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
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function like(Article $article)
    {
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
}
