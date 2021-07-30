<?php

namespace Tests\Unit;

use Tests\ModelTestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Document;

class UserTest extends ModelTestCase
{
    protected $user;

    public function setUp(): void
    {
        $this->user = new User();
        parent::setUp();
    }

    public function tearDown(): void
    {
        $this->user = null;
        parent::tearDown();
    }

    public function testGuarded()
    {
        $guarded = [
            'role_id',
        ];
        $this->assertEquals($guarded, $this->user->getGuarded());
    }

    public function testRoleRelation()
    {
        $relation = $this->user->role();
        $this->assertBelongsToRelation($relation, new Role());
    }

    public function testDownloadRelation()
    {
        $relation = $this->user->downloads();
        $this->assertBelongsToManyRelation($relation, $this->user, new Document());
    }

    public function testFavoritesRelation()
    {
        $relation = $this->user->favorites();

        $this->assertBelongsToManyRelation($relation, $this->user, new Document());
    }

    public function testCommentsRelation()
    {
        $relation = $this->user->comments();
        $this->assertBelongsToManyRelation($relation, $this->user, new Document());
    }

    public function testFollowingsRelation()
    {
        $relation = $this->user->followings();
        $this->assertBelongsToManyRelation($relation, $this->user, new User(), 'user_id', 'follower_id');
    }

    public function testFollowersRelation()
    {
        $relation = $this->user->followers();
        $this->assertBelongsToManyRelation($relation, $this->user, new User(), 'follower_id');
    }

    public function testSendRelation()
    {
        $relation = $this->user->send();
        $this->assertBelongsToManyRelation($relation, $this->user, new User(), 'user_id', 'receiver_id');
    }

    public function testReceiveRelation()
    {
        $relation = $this->user->receive();
        $this->assertBelongsToManyRelation($relation, $this->user, new User(), 'receiver_id');
    }

    public function testReceiptsRelation()
    {
        $relation = $this->user->receipts();
        $this->assertHasManyRelation($relation, $this->user);
    }

    public function testDocumentsRelation()
    {
        $relation = $this->user->documents();
        $this->assertHasManyRelation($relation, $this->user);
    }
}
