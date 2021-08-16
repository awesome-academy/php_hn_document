<?php

namespace App\Repositories\MessageRepository;

use App\Repositories\RepositoryInterface;

interface MessageRepositoryInterface extends RepositoryInterface
{
    public function getMessageBetweenUser($userId, $receiverId);

    public function sendEvent($receiverId, $data);
}
