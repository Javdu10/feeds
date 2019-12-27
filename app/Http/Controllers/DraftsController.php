<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drafts = Auth::user()->drafts;

        return view('drafts.index', compact('drafts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $draft = Draft::create(['owner_id'=>Auth::id()]);
        return view('drafts.edit', compact('draft'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Draft  $draft
     * @return \Illuminate\Http\Response
     */
    public function edit(Draft $draft)
    {
        
        return view('drafts.edit', compact('draft'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Draft  $draft
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Draft $draft)
    {
        $data = [
            'title' => request('title'),
            'heading' => request('heading'),
            'body' => htmlentities(request('body')),
        ];
        $draft->retag(request('tags'));
        $draft->update($data);

        return 'Saved';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Draft  $draft
     * @return \Illuminate\Http\Response
     */
    public function destroy(Draft $draft)
    {
        $draft->delete();
        return redirect('drafts')->with('success-publish', "le brouillon a été correctement publié");
    }

    /**
     * Change Draft to Article.
     *
     * @param  \App\Draft  $draft
     * @return \Illuminate\Http\Response
     */
    public function publish(Draft $draft)
    {
        if(empty($draft->title) || empty($draft->heading) )
            return redirect('drafts/'.$draft->id.'/edit')->with('error-publish', "Il manque soit le titre soit la phrase d'accroche pour publier l'article.");
           
        $article = Article::create([
            'title' =>$draft->title,
            'heading' => $draft->heading,
            'body' => $draft->body,
            'owner_id' => $draft->owner_id
        ]);
        $array_tag = "";
        foreach ($draft->tags as $tag) {
            $array_tag.=",$tag->name";
        }
        $draft->delete();
        $article->tag($array_tag);
        $article->save();
        return redirect('drafts')->with('success-publish', "l'article a été correctement publié");
    }

    
}
