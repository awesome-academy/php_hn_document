<?php

namespace Tests\Unit;

use App\Models\Conversation;
use Tests\ModelTestCase;
use App\Models\Message;
use App\Models\User;

class MessageTest extends ModelTestCase
{
    protected $message;

    public function setUp(): void
    {
        parent::setUp();
        $this->message = new Message();
    }

    public function tearDown(): void
    {
        $this->message = null;
        parent::tearDown();
    }

    public function testFillable()
    {
        $fillable = [
            'receiver_id',
            'user_id',
            'content',
            'conversation_id',
            'is_read',
        ];
        $this->assertEquals($fillable, $this->message->getFillable());
    }

    public function testSender()
    {
        $relation = $this->message->sender();
        $this->assertBelongsToRelation($relation, new User());
    }

    public function testReceiver()
    {
        $relation = $this->message->receiver();
        $this->assertBelongsToRelation($relation, new User(), 'receiver_id');
    }

    public function testConversation()
    {
        $relation = $this->message->conversation();
        $this->assertBelongsToRelation($relation, new Conversation());
    }
}
