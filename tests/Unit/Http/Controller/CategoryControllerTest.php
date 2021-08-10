<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Requests\CategoryRequest;

class CategoryControllerTest extends TestCase
{
    protected $cateMock;
    protected $cateController;

    public function setUp(): void
    {
        parent::setUp();
        $this->cateMock = Mockery::mock(CateGoryRepositoryInterface::class)->makePartial();
        $this->cateController = new CategoryController($this->cateMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->cateController);
        unset($this->cateMock);
        parent::tearDown();
    }

    public function testIndex()
    {
        $controller = $this->cateController->index();
        $this->assertEquals('admin.categories.list', $controller->getName());
    }

    public function testCreate()
    {
        $categories = factory(Category::class, 5)->make();
        $this->cateMock->shouldReceive('getChildCategoriesFromRoot')->andReturn($categories);
        $controller = $this->cateController->create();
        $this->assertEquals('admin.categories.add', $controller->getName());
        $this->assertArrayHasKey('categories', $controller->getData());
    }

    public function testStore()
    {
        $request = new CategoryRequest();
        $request->name = 'test_name';
        $request->category = 1;
        $parentId = ($request->category ?? config('uploads.category_root'));
        $this->cateMock->shouldReceive('create')->with([
            'name' => $request->name,
            'parent_id' => $parentId,
        ]);
        $controller = $this->cateController->store($request);
        $this->assertEquals(route('admin.categories.index'), $controller->getTargetUrl());
    }

    public function testEdit()
    {
        $categories = factory(Category::class, 5)->make();
        $category = factory(Category::class)->make();
        $category_parent = factory(Category::class)->make();
        $category->id = 1;
        $category->setRelation('parent', $category_parent);
        $this->cateMock->shouldReceive('find')->andReturn($category);
        $this->cateMock->shouldReceive('getChildCategoriesFromRoot')->andReturn($categories);
        $controller = $this->cateController->edit($category->id);
        $this->assertEquals('admin.categories.edit', $controller->getName());
        $this->assertArrayHasKey('parent', $controller->getData());
        $this->assertArrayHasKey('categories', $controller->getData());
        $this->assertArrayHasKey('thisCategory', $controller->getData());
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->make();
        $category->id = 1;
        $this->cateMock->shouldReceive('find')->andReturn($category);
        $request = new Request();
        $request->name = 'test_name';
        $request->category = 1;
        $attr = [
            'name' => $request->name,
            'parent_id' => $request->category,
        ];
        $this->cateMock->shouldReceive('update')->with($category->id, $attr);
        $controller = $this->cateController->update($request, $category->id);
        $this->assertEquals(route('admin.categories.index'), $controller->getTargetUrl());
    }

    public function testDestroyHaveChildSuccess()
    {
        $category = factory(Category::class)->make();
        $category->id = 1;
        $this->cateMock->shouldReceive('find')->andReturn($category);
        $this->cateMock->shouldReceive('countChildCategories')
            ->with($category)
            ->andReturn(1);
        $attribute = [
            'parent_id' => $category->parent_id,
        ];

        $category_id = [
            'category_id' => $category->parent_id,
        ];
        $this->cateMock->shouldReceive('updateDocumentsCategory')
            ->with($category, $category_id)
            ->andReturn($category);
        $this->cateMock->shouldReceive('updateChildCategoriesParent')
            ->with($category, $attribute)
            ->andReturn($category);
        $this->cateMock->shouldReceive('delete')
            ->with($category->id)
            ->andReturn(true);
        $controller = $this->cateController->destroy($category->id);
        $title = __('category.success');
        $message = __('category.delete_success');
        $data = [
            'message' => $message,
            'title' => $title,
        ];
        $this->assertEquals($data, $controller->original);
    }

    public function testDestroyFail()
    {
        $category = factory(Category::class)->make();
        $category->id = 1;
        $this->cateMock->shouldReceive('find')->andReturn($category);
        $this->cateMock->shouldReceive('countChildCategories')
            ->with($category)
            ->andReturn(0);
        $this->cateMock->shouldReceive('delete')
            ->with($category->id)
            ->andReturn(false);
        $controller = $this->cateController->destroy($category->id);
        $title = __('category.error');
        $message = __('category.delete_error');
        $data = [
            'message' => $message,
            'title' => $title,
        ];
        $this->assertEquals($data, $controller->original);
    }
}
