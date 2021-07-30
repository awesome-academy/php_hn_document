<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getFollowings($user);

    public function follow($user, $follow_id);

    public function unfollow($user, $follow_id);

    public function setRole($user, $role_id);

    public function getRoleAdmin();

    public function setReceipt($attributes = []);
}
