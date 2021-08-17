<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
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
use Mockery\Mock;
use Yajra\DataTables\DataTables;

class AdminControllerTest extends TestCase
{
    protected $documentMock;
    protected $receiptMock;
    protected $adminController;

    public function setUp(): void
    {
        parent::setUp();
        $this->documentMock = Mockery::mock(DocumentRepositoryInterface::class)->makePartial();
        $this->receiptMock = Mockery::mock(ReceiptRepositoryInterface::class)->makePartial();
        $this->adminController = new AdminController(
            $this->documentMock,
            $this->receiptMock
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->adminController);
        unset($this->documentMock);
        unset($this->receiptMock);
        parent::tearDown();
    }

    public function testIndex()
    {
        $uploadMonth = [];
        $downloadMonth = [];
        $this->receiptMock->shouldReceive('getYearsStatistic');
        $this->receiptMock->shouldReceive('getCoinsPerMonth');
        $this->documentMock->shouldReceive('getYearsStatistic');
        $this->documentMock->shouldReceive('getDataPerMonth')->andReturn($uploadMonth);
        $this->documentMock->shouldReceive('getDataPerMonth')->andReturn($downloadMonth);
        $controller = $this->adminController->index();
        $this->assertEquals('admin.index', $controller->getName());
        $this->assertArrayHasKey('downloadMonth', $controller->getData());
        $this->assertArrayHasKey('uploadMonth', $controller->getData());
        $this->assertArrayHasKey('coin', $controller->getData());
        $this->assertArrayHasKey('years', $controller->getData());
        $this->assertArrayHasKey('year_coin', $controller->getData());
    }

    public function testGetDocuments()
    {
        $this->documentMock->shouldReceive('getData')
            ->once()
            ->andReturn(new Collection);

        $controller = $this->adminController->getDocuments();
        $this->assertEquals(config('code.success'), $controller->status());
    }

    public function testDocumentList()
    {
        $controller = $this->adminController->documentList();
        $this->assertEquals('admin.documents.list', $controller->getName());
    }

    public function testDeleteDocumentSuccess()
    {
        $id = rand();
        $this->documentMock->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        $controller = $this->adminController->deleteDocument($id);
        $this->assertEquals(config('code.success'), $controller->status());
    }

    public function testDeleteDocumentError()
    {
        $id = rand();
        $this->documentMock->shouldReceive('delete')
            ->once()
            ->andReturn(false);
        $controller = $this->adminController->deleteDocument($id);
        $this->assertEquals(config('code.server_error'), $controller->status());
    }

    public function testRestoreDocumentSuccess()
    {
        $id = rand();
        $this->documentMock->shouldReceive('restore')
            ->once()
            ->andReturn(true);
        $controller = $this->adminController->restoreDocument($id);
        $this->assertEquals(config('code.success'), $controller->status());
    }

    public function testRestoreDocumentError()
    {
        $id = rand();
        $this->documentMock->shouldReceive('restore')
            ->once()
            ->andReturn(false);
        $controller = $this->adminController->restoreDocument($id);
        $this->assertEquals(config('code.server_error'), $controller->status());
    }
}
