<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $category = new Category();
        $this->assertEquals([
            'name',
            'parent_id',
        ], $category->getFillable());
    }

    public function testCategoriesRelation()
    {
        $category = new Category();
        $relation = $category->categories();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function testDocumentsRelation()
    {
        $category = new Category();
        $relation = $category->documents();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('category_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function testParentRelation()
    {
        $category = new Category();
        $relation = $category->parent();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function testChildCategoriesRelation()
    {
        $category = new Category();
        $relation = $category->childCategories();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function testTableName()
    {
        $category = new Category();
        $this->assertEquals('categories', $category->getTable());
    }
}
