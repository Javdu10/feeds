<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->id !== Auth::id())
            abort(403);
        return view('settings.tags', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($user->id !== Auth::id())
            abort(403);
        
        $user->retag(request('tags'));
        $user->save();
        return redirect("/users/$user->id")->with('success-message', 'Préférences enregistrées');
    }
}
