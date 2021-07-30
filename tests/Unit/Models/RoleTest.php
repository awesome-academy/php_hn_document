<?php

namespace Tests\Unit;

use Tests\ModelTestCase;
use App\Models\Role;

class RoleTest extends ModelTestCase
{
    protected $role;

    public function setUp(): void
    {
        $this->role = new Role();
        parent::setUp();
    }

    public function tearDown(): void
    {
        $this->role = null;
        parent::tearDown();
    }

    public function testUserRelation()
    {
        $relation = $this->role->user();
        $this->assertHasOneRelation($relation, $this->role);
    }
}
