<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\UserController;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\UploadedFile;

class UserControllerTest extends TestCase
{
    protected $userMock;
    protected $cateMock;
    protected $userController;

    public function setUp(): void
    {
        parent::setUp();
        $this->userMock = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->cateMock = Mockery::mock(CateGoryRepositoryInterface::class)->makePartial();
        $this->userController = new UserController($this->userMock, $this->cateMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->userController);
        unset($this->userMock);
        unset($this->cateMock);
        parent::tearDown();
    }

    public function testShow()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $categories = factory(Category::class, 5)->make();
        $this->userMock->shouldReceive('find')->andReturn($user);
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $this->be($user);
        $controller = $this->userController->show($user->id);
        $this->assertEquals('user.profile', $controller->getName());
        $this->assertArrayHasKey('user', $controller->getData());
        $this->assertArrayHasKey('categories', $controller->getData());
        $this->assertArrayHasKey('check', $controller->getData());
        $this->assertArrayHasKey('follow', $controller->getData());
    }

    public function testShowAnotherUser()
    {
        $user = factory(User::class)->make();
        $list_follow = factory(User::class, 3)->make();
        $user_follow = $list_follow->first();
        $user->id = 1;
        $user_follow->id = 2;
        $this->be($user);
        $categories = factory(Category::class, 5)->make();
        $this->userMock->shouldReceive('find')->andReturn($user_follow);
        $this->userMock->shouldReceive('getFollowings')->andReturn($list_follow);
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $controller = $this->userController->show($user_follow->id);
        $this->assertEquals('user.profile', $controller->getName());
        $this->assertArrayHasKey('user', $controller->getData());
        $this->assertArrayHasKey('categories', $controller->getData());
        $this->assertArrayHasKey('check', $controller->getData());
        $this->assertArrayHasKey('follow', $controller->getData());
    }

    public function testEdit()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $categories = factory(Category::class, 5)->make();
        $this->userMock->shouldReceive('find')->andReturn($user);
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $this->be($user);
        $controller = $this->userController->edit($user->id);
        $this->assertEquals('user.edit-profile', $controller->getName());
        $this->assertArrayHasKey('user', $controller->getData());
        $this->assertArrayHasKey('categories', $controller->getData());
    }

    public function testEditUnAuthorized()
    {
        $user = factory(User::class)->make();
        $user_login = factory(User::class)->make();
        $user->id = 1;
        $user_login->id = 2;
        $categories = factory(Category::class, 5)->make();
        $this->userMock->shouldReceive('find')->andReturn($user);
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $this->be($user_login);
        $this->expectException(AuthorizationException::class);
        $this->userController->edit($user->id);
    }

    public function testUpdateHaveAvatar()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->be($user);
        $this->userMock->shouldReceive('find')->andReturn($user);
        $request = new UpdateUserRequest();
        $request->avatar = UploadedFile::fake()->image('test.jpg');
        $request->name = 'test_name';
        $request->email = 'test.email.gmail.com';
        $avatar = $request->avatar;
        $avatar_name = $avatar->getClientOriginalName();
        $path = 'images/web/';
        $this->userMock->shouldReceive('update')
            ->with($user->id, $request->all());
        $this->userMock->shouldReceive('update')
            ->with($user->id, [
                'image' => $path . $avatar_name
            ]);
        $controller = $this->userController->update($request, $user->id);
        $this->assertEquals(route('users.show', ['user' => $user->id]), $controller->getTargetUrl());
    }

    public function testUpdateAvatarNull()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->be($user);
        $this->userMock->shouldReceive('find')->andReturn($user);
        $request = new UpdateUserRequest();
        $request->name = 'test_name';
        $request->email = 'test.email.gmail.com';
        $this->userMock->shouldReceive('update')
            ->with($user->id, $request->all());
        $controller = $this->userController->update($request, $user->id);
        $this->assertEquals(route('users.show', ['user' => $user->id]), $controller->getTargetUrl());
    }

    public function testUpdateUnAuthorized()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $user_login = factory(User::class)->make();
        $user_login->id = 2;
        $this->userMock->shouldReceive('find')->andReturn($user);
        $request = new UpdateUserRequest();
        $this->be($user_login);
        $this->expectException(AuthorizationException::class);
        $this->userController->update($request, $user->id);
    }

    public function testFollowUnAuthorized()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->userMock->shouldReceive('find')->andReturn($user);
        $this->be($user);
        $this->expectException(AuthorizationException::class);
        $this->userController->follow($user->id);
    }

    public function testFollow()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $user_follow = factory(User::class)->make();
        $user_follow->id = 2;
        $this->userMock->shouldReceive('find')->andReturn($user_follow);
        $this->be($user);
        $this->userMock->shouldReceive('follow')->with($user, $user_follow->id);
        $this->userMock->shouldReceive('sendFollowing')->with($user, $user_follow);
        $controller = $this->userController->follow($user_follow->id);
        $this->assertEquals(route('users.show', ['user' => $user_follow->id]), $controller->getTargetUrl());
    }

    public function testUnFollowUnAuthorized()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->userMock->shouldReceive('find')->andReturn($user);
        $this->be($user);
        $this->expectException(AuthorizationException::class);
        $this->userController->unfollow($user->id);
    }

    public function testUnFollow()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $user_follow = factory(User::class)->make();
        $user_follow->id = 2;
        $this->userMock->shouldReceive('find')->andReturn($user_follow);
        $this->be($user);
        $this->userMock->shouldReceive('unfollow')->with($user, $user_follow->id);
        $controller = $this->userController->unfollow($user_follow->id);
        $this->assertEquals(route('users.show', ['user' => $user_follow->id]), $controller->getTargetUrl());
    }

    public function testBuyCoin()
    {
        $categories = factory(Category::class, 5)->make();
        $this->cateMock->shouldReceive('getCategoriesRoot')->andReturn($categories);
        $controller = $this->userController->buyCoin();
        $this->assertEquals('user.buy-coin', $controller->getName());
        $this->assertArrayHasKey('categories', $controller->getData());
    }

    public function testPayment()
    {
        $user = factory(User::class)->make();
        $user->id = 1;
        $this->be($user);
        $request = new PaymentRequest();
        $request->quantity = 1;
        $request->value = 10;
        $coin = [
            'coin' => $user->coin + $request->value * $request->quantity
        ];
        $receipt = [
            'value' => $request->value,
            'quantity' => $request->quantity,
            'user_id' => $user->id,
        ];
        $this->userMock->shouldReceive('update')->with($user->id, $coin);
        $this->userMock->shouldReceive('setReceipt')->with($receipt);
        $controller = $this->userController->payment($request, $user->id);
        $this->assertEquals(route('users.show', ['user' => $user->id]), $controller->getTargetUrl());
    }
}
