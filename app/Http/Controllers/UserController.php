<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $check = false;
        $follow = false;
        if (Auth::check() && Auth::id() == $user->id) {
            $check = true;
        } elseif (Auth::user()->followings->contains($user)) {
            $follow = true;
        }

        return view('user.profile', compact('user', 'check', 'follow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit-profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        $avatar = $request->avatar;
        if (isset($avatar)) {
            $url = cloudinary()->upload($avatar->getRealPath())->getSecurePath();
            $user->image = $url;
        }
        $user->save();

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function follow($id)
    {
        $user = User::findOrFail($id);
        $userLogin = Auth::user();
        $userLogin->followings()->attach($user->id);

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);
        $userLogin = Auth::user();
        $userLogin->followings()->detach($user->id);

        return redirect()->route('users.show', ['user' => $user->id]);
    }
}
