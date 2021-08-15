<?php

namespace App\Repositories\MessageRepository;

use App\Repositories\BaseRepository;
use App\Models\Message;
use Pusher\Pusher;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function getModel()
    {
        return Message::class;
    }

    public function getMessageBetweenUser($userId, $receiverId)
    {
        return $this->model->where([['user_id', $userId], ['receiver_id', $receiverId]])
            ->orWhere([['user_id', $receiverId], ['receiver_id', $userId]])->get();
    }

    public function sendEvent($receiverId, $data)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options'),
        );
        $pusher->trigger('MessageEvent', 'chat.' . $receiverId, $data);
    }
}
