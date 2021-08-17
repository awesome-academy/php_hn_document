<?php

namespace Tests\Unit\Http\Controller;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use Tests\TestCase;
use Mockery;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Repositories\DocumentRepository\DocumentRepositoryInterface;
use App\Repositories\ReceiptRepository\ReceiptRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Mockery\Mock;

class NotificationControllerTest extends TestCase
{
    protected $userMock;
    protected $notificationController;

    public function setUp(): void
    {
        parent::setUp();
        $this->userMock = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->notificationController = new NotificationController($this->userMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->notificationController);
        unset($this->userMock);
        parent::tearDown();
    }

    public function testMark()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $id = 1;
        $this->userMock->shouldReceive('markNotification');
        $controller = $this->notificationController->mark($id);
        $this->assertEquals(route('users.show', ['user' => $id]), $controller->getTargetUrl());
    }

    public function testMarkAll()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $this->userMock->shouldReceive('markAllNotification');
        $controller = $this->notificationController->markAll();
        $this->assertInstanceOf(RedirectResponse::class, $controller);
    }
}
