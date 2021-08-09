<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PaymentRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\Receipt;

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
        $categories =  $this->cateRepo->getCategoriesRoot();
        if ($user) {
            $check = false;
            $follow = false;
            if (Auth::check() && Auth::id() == $user->id) {
                $check = true;
            } elseif ($this->userRepo->getFollowings(Auth::user())->contains($user)) {
                $follow = true;
            }

            return view('user.profile', compact('user', 'check', 'follow', 'categories'));
        }

        return view('user.not-found', compact('categories'));
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
        if ($user) {
            $this->authorize('update', $user);

            return view('user.edit-profile', compact('user', 'categories'));
        }

        return view('user.not-found', compact('categories'));
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
        if ($user) {
            $this->authorize('update', $user);
            $this->userRepo->update($user->id, $request->all());
            $avatar = $request->avatar;
            if (isset($avatar)) {
                $avatar_name = $avatar->getClientOriginalName();
                $path = 'images/web/';
                $avatar->storeAs($path, $avatar_name);
                $this->userRepo->update($user->id, [
                    'image' => $path . $avatar_name
                ]);
            }

            return redirect()->route('users.show', ['user' => $user->id]);
        } else {
            $categories =  $this->cateRepo->getCategoriesRoot();

            return view('user.not-found', compact('categories'));
        }
    }

    public function follow($id)
    {
        $user = $this->userRepo->find($id);
        if ($user) {
            $this->authorize('follow', $user);
            $userLogin = Auth::user();
            $this->userRepo->follow($userLogin, $user->id);

            return redirect()->route('users.show', ['user' => $user->id]);
        } else {
            $categories =  $this->cateRepo->getCategoriesRoot();

            return view('user.not-found', compact('categories'));
        }
    }

    public function unfollow($id)
    {
        $user = $this->userRepo->find($id);
        if ($user) {
            $this->authorize('follow', $user);
            $userLogin = Auth::user();
            $this->userRepo->unfollow($userLogin, $user->id);

            return redirect()->route('users.show', ['user' => $user->id]);
        } else {
            $categories =  $this->cateRepo->getCategoriesRoot();

            return view('user.not-found', compact('categories'));
        }
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
        $this->userRepo->update($user->id, [
            'coin' => $user->coin + $value * $quantity
        ]);
        $this->userRepo->setReceipt([
            'value' => $value,
            'quantity' => $quantity,
            'user_id' => $user->id,
        ]);

        $receipt = [
            'value' => $value,
            'quantity' => $quantity,
            'total' => $value * $quantity,
        ];
        Mail::to($user->email)->send(new Receipt($receipt, $user));

        return redirect()->route('users.show', ['user' => $user->id]);
    }
}
