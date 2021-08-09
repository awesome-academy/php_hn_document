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

    public function all()
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

    public function getRoleUser()
    {
        return Role::where('name', config('user.role_user'))->first();
    }

    public function setReceipt($attributes = [])
    {
        return Receipt::create($attributes);
    }

    public function mark($user, $document)
    {
        $user->favorites()->attach($document);

        return true;
    }

    public function unmark($user, $document)
    {
        $user->favorites()->detach($document);

        return true;
    }

    public function download($user, $document)
    {
        $user->downloads()->attach($document);

        return true;
    }

    public function comment($user, $content, $document)
    {
        $user->comments()->attach($document, ['content' => $content]);

        return true;
    }

    public function favoriteDocument($user)
    {
        return $user->favorites()->paginate(config('user.paginate'));
    }

    public function ownDocuments($user)
    {
        return $user->documents()->paginate(config('user.paginate'));
    }
}
