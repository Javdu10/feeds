<?php

namespace App\Http\Controllers;

use App\Draft;
use Illuminate\Http\Request;

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
        $drafts = Draft::all();

        return view('drafts.index', compact('drafts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $draft = new Draft();
        return view('drafts.create', compact('draft'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'heading' => 'required',
            'body' => 'required',
        ]);

        Draft::create($data);

        return redirect('drafts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Draft  $draft
     * @return \Illuminate\Http\Response
     */
    public function show(Draft $draft)
    {
       //
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
        $data = request()->validate([
            'title' => 'required',
            'heading' => 'required',
            'body' => 'required',
        ]);
        
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
        return redirect('drafts');
    }

    
}
