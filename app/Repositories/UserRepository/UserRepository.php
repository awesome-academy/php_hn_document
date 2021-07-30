<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Role;
use App\Models\Receipt;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return User::class;
    }

    public function getAll()
    {
        return $this->model->with('role')->get();
    }

    public function getFollowings($user)
    {
        return $user->followings;
    }

    public function follow($user, $follow_id)
    {
        return  $user->followings()->attach($follow_id);
    }

    public function unfollow($user, $follow_id)
    {
        return  $user->followings()->detach($follow_id);
    }

    public function setRole($user, $role_id)
    {
        $user->role_id = $role_id;
        $user->save();
    }

    public function getRoleAdmin()
    {
        return Role::where('name', config('user.role_admin'))->first();
    }

    public function setReceipt($attributes = [])
    {
        return Receipt::create($attributes);
    }
}
