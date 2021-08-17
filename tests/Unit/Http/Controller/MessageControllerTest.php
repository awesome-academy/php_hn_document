<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\MessageController;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ConversationRepository\ConversationRepositoryInterface;
use App\Repositories\MessageRepository\MessageRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Mockery\Mock;

class MessageControllerTest extends TestCase
{
    protected $messageMock;
    protected $cateMock;
    protected $conversationMock;
    protected $userMock;
    protected $messageController;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageMock = Mockery::mock(MessageRepositoryInterface::class)->makePartial();
        $this->cateMock = Mockery::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->conversationMock = Mockery::mock(ConversationRepositoryInterface::class)->makePartial();
        $this->userMock = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->messageController = new MessageController(
            $this->messageMock,
            $this->cateMock,
            $this->conversationMock,
            $this->userMock
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->messageController);
        unset($this->messageMock);
        unset($this->cateMock);
        unset($this->conversationMock);
        unset($this->userMock);
        parent::tearDown();
    }

    public function testIndex()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->be($user);
        $categories = factory(Category::class, 5)->make();
        $listConversation = factory(Conversation::class, 2)->make();
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        foreach ($listConversation as $conversation) {
            $conversation->messages = factory(Message::class, 2)->make();
            $conversation->user = factory(User::class)->make();
            $conversation->partner = factory(User::class)->make();
        }
        $this->conversationMock->shouldReceive('getListConversation')->andReturn($listConversation);
        $this->conversationMock->shouldReceive('updateRead')->andReturn(true);
        $controller = $this->messageController->index();
        $this->assertEquals('user.chat', $controller->getName());
        $this->assertArrayHasKey('categories', $controller->getData());
        $this->assertArrayHasKey('messages', $controller->getData());
        $this->assertArrayHasKey('listConversation', $controller->getData());
        $this->assertArrayHasKey('receiver', $controller->getData());
    }

    public function testGetMessages()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $receiver = factory(User::class)->make();
        $receiver->id = 1;
        $this->be($user);
        $categories = factory(Category::class, 5)->make();
        $listConversation = factory(Conversation::class, 2)->make();
        $conversation = factory(Conversation::class, 1)->make();
        foreach ($listConversation as $conversation) {
            $conversation->messages = factory(Message::class, 2)->make();
            $conversation->user = factory(User::class)->make();
            $conversation->partner = factory(User::class)->make();
        }
        $this->userMock->shouldReceive('find')->andReturn($receiver);
        $this->conversationMock->shouldReceive('getConversation')->andReturn($conversation);
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $this->conversationMock->shouldReceive('getListConversation')->andReturn($listConversation);
        $this->conversationMock->shouldReceive('updateRead')->andReturn(true);
        $controller = $this->messageController->getMessages($receiver->id);
        $this->assertEquals('user.chat', $controller->getName());
        $this->assertArrayHasKey('categories', $controller->getData());
        $this->assertArrayHasKey('messages', $controller->getData());
        $this->assertArrayHasKey('listConversation', $controller->getData());
        $this->assertArrayHasKey('receiver', $controller->getData());
    }

    public function testGetMessagesNotConversation()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $receiver = factory(User::class)->make();
        $receiver->id = 1;
        $this->be($user);
        $categories = factory(Category::class, 5)->make();
        $listConversation = factory(Conversation::class, 2)->make();
        $conversation = factory(Conversation::class, 1)->make();
        foreach ($listConversation as $conversation) {
            $conversation->messages = factory(Message::class, 2)->make();
            $conversation->user = factory(User::class)->make();
            $conversation->partner = factory(User::class)->make();
        }
        $this->userMock->shouldReceive('find')->andReturn($receiver);
        $this->conversationMock->shouldReceive('getConversation')->andReturn(null);
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $this->conversationMock->shouldReceive('getListConversation')->andReturn($listConversation);
        $controller = $this->messageController->getMessages($receiver->id);
        $this->assertEquals('user.chat', $controller->getName());
        $this->assertArrayHasKey('categories', $controller->getData());
        $this->assertArrayHasKey('messages', $controller->getData());
        $this->assertArrayHasKey('listConversation', $controller->getData());
        $this->assertArrayHasKey('receiver', $controller->getData());
    }

    public function testSendMessage()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $receiver = factory(User::class)->make();
        $receiver->id = 1;
        $this->be($user);
        $request = new Request();
        $request->receiver_id = $receiver->id;
        $request->message = 'hello';
        $conversation = factory(Conversation::class)->make();
        $message = factory(Message::class)->make();
        $messages = factory(Message::class, 5)->make();
        $this->userMock->shouldReceive('find')->andReturn($receiver);
        $this->conversationMock->shouldReceive('getConversation')->andReturn($conversation);
        $this->messageMock->shouldReceive('create')->andReturn($message);
        $this->conversationMock->shouldReceive('update')->andReturn(true);
        $this->messageMock->shouldReceive('getMessageBetweenUser')->andReturn($messages);
        $this->messageMock->shouldReceive('sendEvent');
        $controller = $this->messageController->sendMessage($request);
        $this->assertEquals('user.layouts.message', $controller->getName());
        $this->assertArrayHasKey('messages', $controller->getData());
        $this->assertArrayHasKey('receiver', $controller->getData());
    }

    public function testSendMessageNotConversation()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $receiver = factory(User::class)->make();
        $receiver->id = 1;
        $this->be($user);
        $request = new Request();
        $request->receiver_id = $receiver->id;
        $request->message = 'hello';
        $conversation = factory(Conversation::class)->make();
        $message = factory(Message::class)->make();
        $messages = factory(Message::class, 5)->make();
        $this->userMock->shouldReceive('find')->andReturn($receiver);
        $this->conversationMock->shouldReceive('getConversation')->andReturn(null);
        $this->messageMock->shouldReceive('create')->andReturn($message);
        $this->conversationMock->shouldReceive('create')->andReturn($conversation);
        $this->conversationMock->shouldReceive('update')->andReturn(true);
        $this->messageMock->shouldReceive('getMessageBetweenUser')->andReturn($messages);
        $this->messageMock->shouldReceive('sendEvent');
        $controller = $this->messageController->sendMessage($request);
        $this->assertEquals('user.layouts.message', $controller->getName());
        $this->assertArrayHasKey('messages', $controller->getData());
        $this->assertArrayHasKey('receiver', $controller->getData());
    }

    public function testGetListConversation()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->be($user);
        $listConversation = factory(Conversation::class, 2)->make();
        foreach ($listConversation as $conversation) {
            $conversation->messages = factory(Message::class, 2)->make();
            $conversation->user = factory(User::class)->make();
            $conversation->partner = factory(User::class)->make();
        }
        $this->conversationMock->shouldReceive('getListConversation')->andReturn($listConversation);
        $controller = $this->messageController->getListConversation();
        $this->assertEquals('user.layouts.conversation', $controller->getName());
        $this->assertArrayHasKey('listConversation', $controller->getData());
    }

    public function testGetConversation()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->be($user);
        $conversation = factory(Conversation::class)->make();
        $conversation->user = factory(User::class)->make();
        $conversation->partner = factory(User::class)->make();
        $this->conversationMock->shouldReceive('find')->andReturn($conversation);
        $this->conversationMock->shouldReceive('updateRead')->andReturn($conversation);
        $controller = $this->messageController->getConversation($conversation->id);
        $this->assertEquals('user.layouts.message', $controller->getName());
        $this->assertArrayHasKey('messages', $controller->getData());
        $this->assertArrayHasKey('receiver', $controller->getData());
    }
}
