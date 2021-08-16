<?php

namespace App\Repositories\User;

use App\Notifications\FollowingNotification;
use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Role;
use App\Models\Receipt;
use Pusher\Pusher;

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

    public function sendFollowing($userLogin, $user)
    {
        $data = [
            'following' => 'notification.following_message',
            'name' => $userLogin->name,
            'id' => $userLogin->id,
            'user' => $user->id,
            'image' =>  asset($userLogin->image ?? asset(config('user.image_default'))),
        ];
        $user->notify(new FollowingNotification($data));
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('following-notification.' . $user->id, 'SendFollowing', $data);
    }
}
