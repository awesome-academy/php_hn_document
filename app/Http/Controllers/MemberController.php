<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = User::with('role')->get();

        return view('admin.members.list', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.members.add_new');
    }

    public function store(MemberRequest $request)
    {
        $image = $request->file;
        $path = '';
        $imageName = '';
        if (isset($image)) {
            $fileName = $image->getClientOriginalName();
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $path = 'images/members/';
            $imageName = $request->name . "." . $extension;
            $image->storeAs($path, $imageName);
        }
        $member = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'about' => $request->about,
            'image' => $path . $imageName ?? null,
            'status' => config('user.confirm'),
            'download_free' => config('user.download_free'),
            'upload' => config('user.upload'),
            'coin' => config('user.coin'),
            'password' => Hash::make($request->password),
        ]);
        $role = Role::where('name', config('user.role_admin'))->first();
        $member->role_id = $role->id;
        $member->save();

        $message = __('member.add_success');

        return redirect(route('admin.members.index'))->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function upgrade($id)
    {
        $member = User::findOrFail($id);
        $roleAdmin = Role::where('name', config('user.role_admin'))->first();
        $member->role_id = $roleAdmin->id;
        $member->save();

        $message = __('member.upgrade_success');

        return redirect(route('admin.members.index'))->with('success', $message);
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

    public function ban($id)
    {
        $member = User::findOrFail($id);
        $status =  config('user.banned_status');
        $member->update([
            'status' => $status,
        ]);
        $message = __('member.ban_success');

        return redirect(route('admin.members.index'))->with('success', $message);
    }
}
