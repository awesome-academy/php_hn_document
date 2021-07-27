<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $userNeedAuthor)
    {
        return $user->id === $userNeedAuthor->id;
    }

    public function follow(User $user, User $userNeedAuthor)
    {
        return $user->id !== $userNeedAuthor->id;
    }
}
