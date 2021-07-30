<?php

namespace Tests\Unit;

use Tests\ModelTestCase;
use App\Models\Receipt;
use App\Models\User;

class ReceiptTest extends ModelTestCase
{
    protected $receipt;

    public function setUp(): void
    {
        $this->receipt = new Receipt();
        parent::setUp();
    }

    public function tearDown(): void
    {
        $this->receipt = null;
        parent::tearDown();
    }

    public function testFillable()
    {
        $fillable = [
            'value',
            'quantity',
            'user_id',
        ];
        $this->assertEquals($fillable, $this->receipt->getFillable());
    }

    public function testUserRelation()
    {
        $relation = $this->receipt->user();
        $this->assertBelongsToRelation($relation, new User());
    }
}
