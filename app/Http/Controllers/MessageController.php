<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\MessageRepository\MessageRepositoryInterface;
use App\Repositories\ConversationRepository\ConversationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class MessageController extends Controller
{
    protected $messageRepo;
    protected $cateRepo;
    protected $conversationRepo;
    protected $userRepo;

    public function __construct(
        MessageRepositoryInterface $messageRepo,
        CategoryRepositoryInterface $cateRepo,
        ConversationRepositoryInterface $conversationRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->middleware('auth');
        $this->cateRepo = $cateRepo;
        $this->messageRepo = $messageRepo;
        $this->conversationRepo = $conversationRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $categories = $this->cateRepo->getCategoriesRoot();
        $listConversation = $this->conversationRepo->getListConversation(Auth::id());
        foreach ($listConversation as $conversation) {
            $conversation->message = $conversation->messages->sortByDesc('updated_at')->first();
            $conversation->isRead = $conversation->message->is_read;
            $conversation->user = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        }
        $conversation = $listConversation->first();
        $this->conversationRepo->updateRead($conversation);
        $receiver = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        $messages = $conversation->messages;

        return view('user.chat', compact('categories', 'listConversation', 'messages', 'receiver'));
    }

    public function getMessages($id)
    {
        $categories = $this->cateRepo->getCategoriesRoot();
        $listConversation = $this->conversationRepo->getListConversation(Auth::id());
        foreach ($listConversation as $conversation) {
            $conversation->message = $conversation->messages->sortByDesc('updated_at')->first();
            $conversation->isRead = $conversation->message->is_read;
            $conversation->user = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        }
        $receiver = $this->userRepo->find($id);
        $conversation = $this->conversationRepo->getConversation(Auth::id(), $id);
        if (!$conversation) {
            $messages = [];

            return view('user.chat', compact('categories', 'listConversation', 'messages', 'receiver'));
        }
        $this->conversationRepo->updateRead($conversation);
        $messages = $conversation->messages;

        return view('user.chat', compact('categories', 'listConversation', 'messages', 'receiver'));
    }

    public function sendMessage(Request $request)
    {
        $userId = Auth::id();
        $receiverId = $request->receiver_id;
        $receiver = $this->userRepo->find($receiverId);
        $message = $request->message;
        $conversation = $this->conversationRepo->getConversation($userId, $receiverId);
        if (!$conversation) {
            $conversation = $this->conversationRepo->create([
                'user_id' => $userId,
                'partner_id' => $receiverId,
            ]);
        }
        $newMessage = $this->messageRepo->create([
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'content' => $message,
            'conversation_id' => $conversation->id,
            'is_read' => 1
        ]);
        $this->conversationRepo->update($conversation->id, [
            'last_message' => $newMessage->id
        ]);
        $messages = $this->messageRepo->getMessageBetweenUser(Auth::id(), $receiverId);
        $data = [
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'content' => $message,
            'created_at' => date('H:i:s', strtotime($newMessage->created_at)),
        ];
        $this->messageRepo->sendEvent($receiverId, $data);


        return view('user.layouts.message', compact('messages', 'receiver'));
    }

    public function getListConversation()
    {
        $listConversation = $this->conversationRepo->getListConversation(Auth::id());
        foreach ($listConversation as $conversation) {
            $conversation->message = $conversation->messages->sortByDesc('updated_at')->first();
            $conversation->isRead = $conversation->message->is_read;
            $conversation->user = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;
        }

        return view('user.layouts.conversation', compact('listConversation'));
    }

    public function getConversation($id)
    {
        $conversation = $this->conversationRepo->find($id);
        $this->conversationRepo->updateRead($conversation);
        $messages = $conversation->messages;
        $receiver = $conversation->user_id === Auth::id() ? $conversation->partner : $conversation->user;

        return view('user.layouts.message', compact('messages', 'receiver'));
    }
}
