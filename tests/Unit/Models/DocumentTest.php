<?php

namespace Tests\Unit\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $document = new Document();
        $this->assertEquals([
            'name',
            'description',
            'url',
            'category_id',
            'user_id',
        ], $document->getFillable());
    }

    public function testDownloadsRelation()
    {
        $document = new Document();
        $relation = $document->downloads();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertEquals('downloads.document_id', $relation->getQualifiedForeignPivotKeyName());
        $this->assertEquals('downloads.user_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testFavoritesRelation()
    {
        $document = new Document();
        $relation = $document->favorites();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertEquals('favorites.document_id', $relation->getQualifiedForeignPivotKeyName());
        $this->assertEquals('favorites.user_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testCommentsRelation()
    {
        $document = new Document();
        $relation = $document->comments();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertEquals('comments.document_id', $relation->getQualifiedForeignPivotKeyName());
        $this->assertEquals('comments.user_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testCategoryRelation()
    {
        $document = new Document();
        $relation = $document->category();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('category_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function testUploadByRelation()
    {
        $document = new Document();
        $relation = $document->uploadBy();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function testTableName()
    {
        $document = new Document();
        $this->assertEquals('documents', $document->getTable());
    }
}
