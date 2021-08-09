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

    public function getRoleUser();

    public function setReceipt($attributes = []);

    public function mark($user, $document);

    public function unmark($user, $document);

    public function download($user, $document);

    public function comment($user, $content, $document);

    public function favoriteDocument($user);

    public function ownDocuments($user);
}
