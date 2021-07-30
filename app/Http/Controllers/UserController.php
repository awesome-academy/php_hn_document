<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Receipt;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class UserController extends Controller
{
    protected $cateRepo;

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo, CategoryRepositoryInterface $cateRepo)
    {
        $this->userRepo = $userRepo;
        $this->cateRepo = $cateRepo;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepo->find($id);
        $check = false;
        $follow = false;
        $categories =  $this->cateRepo->getCategoriesRoot();
        if (Auth::check() && Auth::id() == $user->id) {
            $check = true;
        } elseif ($this->userRepo->getFollowings(Auth::user())->contains($user)) {
            $follow = true;
        }

        return view('user.profile', compact('user', 'check', 'follow', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        $categories =  $this->cateRepo->getCategoriesRoot();
        $this->authorize('update', $user);

        return view('user.edit-profile', compact('user', 'categories'));
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
        $user = $this->userRepo->find($id);
        $this->authorize('update', $user);
        $this->userRepo->update($user, $request->all());
        $avatar = $request->avatar;
        if (isset($avatar)) {
            $avatar_name = $avatar->getClientOriginalName();
            $path = 'images/web/';
            $avatar->storeAs($path, $avatar_name);
            $this->userRepo->update($user, [
                'image' => $path . $avatar_name
            ]);
        }

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function follow($id)
    {
        $user = $this->userRepo->find($id);
        $this->authorize('follow', $user);
        $userLogin = Auth::user();
        $this->userRepo->follow($userLogin, $user->id);

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function unfollow($id)
    {
        $user = $this->userRepo->find($id);
        $this->authorize('follow', $user);
        $userLogin = Auth::user();
        $this->userRepo->unfollow($userLogin, $user->id);

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function buyCoin()
    {
        $categories =  $this->cateRepo->getCategoriesRoot();

        return view('user.buy-coin', compact('categories'));
    }

    public function payment(PaymentRequest $request)
    {
        $value = $request->value;
        $quantity = $request->quantity;
        $user = Auth::user();
        $this->userRepo->update($user, [
            'coin' => $user->coin + $value * $quantity
        ]);
        $this->userRepo->setReceipt([
            'value' => $value,
            'quantity' => $quantity,
            'user_id' => $user->id,
        ]);

        return redirect()->route('users.show', ['user' => $user->id]);
    }
}
