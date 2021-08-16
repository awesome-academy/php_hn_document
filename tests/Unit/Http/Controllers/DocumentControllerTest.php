<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\DocumentController;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\DocumentRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\DocumentRepository\DocumentRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery as m;

class DocumentControllerTest extends TestCase
{
    protected $documentMock;
    protected $categoryMock;
    protected $userMock;
    protected $documentController;

    public function setUp(): void
    {
        $this->documentMock = m::mock(DocumentRepositoryInterface::class);
        $this->userMock = m::mock(UserRepositoryInterface::class);
        $this->categoryMock = m::mock(CategoryRepositoryInterface::class);
        $this->documentController = new DocumentController(
            $this->userMock,
            $this->categoryMock,
            $this->documentMock
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->documentController);
        unset($this->userMock);
        unset($this->categoryMock);
        unset($this->documentMock);
        parent::tearDown();
    }

    public function testIndex()
    {
        $this->userMock
            ->shouldReceive('ownDocuments')
            ->once()
            ->andReturn(new Collection());
        $this->userMock
            ->shouldReceive('favoriteDocument')
            ->once()
            ->andReturn(new Collection());
        $this->categoryMock
            ->shouldReceive('getChildCategoriesFromRoot')
            ->once()
            ->andReturn(new Collection());
        $result = $this->documentController->index();
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('user.documents.list-document', $result->getName());
        $this->assertArrayHasKey('documents', $data);
        $this->assertArrayHasKey('favoriteDocuments', $data);
        $this->assertArrayHasKey('categories', $data);
    }

    public function testShowDocument()
    {
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn(true);
        $this->documentMock
            ->shouldReceive('getComments')
            ->once()
            ->andReturn(new Collection());
        $this->documentMock
            ->shouldReceive('getAuthor')
            ->once()
            ->andReturn(new User());
        $this->categoryMock
            ->shouldReceive('getChildCategoriesFromRoot')
            ->once()
            ->andReturn(new Collection);
        $id = rand();
        $result = $this->documentController->show($id);
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('user.documents.show', $result->getName());
        $this->assertArrayHasKey('document', $data);
        $this->assertArrayHasKey('categories', $data);
        $this->assertArrayHasKey('comments', $data);
        $this->assertArrayHasKey('author', $data);
    }

    public function testShowNotFound()
    {
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn(false);
        $this->categoryMock
            ->shouldReceive('getChildCategoriesFromRoot')
            ->once()
            ->andReturn(new Collection);

        $id = rand();
        $result = $this->documentController->show($id);
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('user.not-found', $result->getName());
        $this->assertArrayHasKey('categories', $data);
    }

    public function testDestroyFunctionSuccess()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $document->setRelation('uploadBy', $user);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->documentMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        $result = $this->documentController->destroy($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testDestroyFunctionFail()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $document->setRelation('uploadBy', $user);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->documentMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn(false);
        $result = $this->documentController->destroy($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testDestroyFunctionUnauthorized()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $author = factory(User::class)->make();
        $author->id = 2;
        $document->setRelation('uploadBy', $author);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->expectException(AuthorizationException::class);
        $result = $this->documentController->destroy($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testUpload()
    {
        $this->categoryMock
            ->shouldReceive('getChildCategoriesFromRoot')
            ->once()
            ->andReturn(new Collection);
        $result = $this->documentController->upload();
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('user.documents.upload', $result->getName());
        $this->assertArrayHasKey('categories', $data);
    }

    public function testStoreUploadSuccess()
    {
        Storage::fake('local');
        $user = factory(User::class)->make();
        $this->be($user);
        $request = new DocumentRequest();
        $request->name = 'test';
        $request->file = 'test.pdf';
        $file = UploadedFile::fake()->create('test.pdf')->store('pdfs');
        Storage::disk('local')->assertExists($file);
        $request->category = 1;
        $request->description = 'test description';
        $url = 'test.pdf';
        $this->documentMock
            ->shouldReceive('saveFile')
            ->once()
            ->andReturn($url);
        $this->documentMock
            ->shouldReceive('getPreviewImages')
            ->once();
        $this->documentMock->shouldReceive('create')->with([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $url,
            'user_id' => $user->id,
            'category_id' => $request->category,
        ]);
        $this->userMock->shouldReceive('update')->with($user->id, [
            'upload' => 9,
            'coin' => 10,
        ]);
        $result = $this->documentController->storeUpload($request);
        $this->assertEquals(route('user.documents.upload'), $result->getTargetUrl());
    }

    public function testStoreUploadExpired()
    {
        $user = factory(User::class)->make();
        $user->upload = 0;
        $user->coin = 0;
        $this->be($user);
        $request = new DocumentRequest();
        $result = $this->documentController->storeUpload($request);
        $this->assertEquals(route('user.documents.upload'), $result->getTargetUrl());
    }

    public function testSearch()
    {
        $document = factory(Document::class, 5)->make();
        $request = new Request();
        $request->name = 'test document';
        $this->documentMock->shouldReceive('search')
            ->once()
            ->andReturn($document);
        $this->categoryMock
            ->shouldReceive('getChildCategoriesFromRoot')
            ->once()
            ->andReturn(new Collection);
        $result = $this->documentController->search($request);
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('user.documents.search', $result->getName());
        $this->assertArrayHasKey('documents', $data);
        $this->assertArrayHasKey('categories', $data);
    }

    public function testMarkFunctionSuccess()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $author = factory(User::class)->make();
        $author->id = 2;
        $document->setRelation('uploadBy', $author);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->userMock
            ->shouldReceive('mark')
            ->with($user, $document)
            ->once()
            ->andReturn(true);
        $result = $this->documentController->mark($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testMarkFunctionUnauthorized()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $document->setRelation('uploadBy', $user);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->expectException(AuthorizationException::class);
        $result = $this->documentController->mark($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testUnmarkFunctionSuccess()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $author = factory(User::class)->make();
        $author->id = 2;
        $document->setRelation('uploadBy', $author);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->userMock
            ->shouldReceive('unmark')
            ->with($user, $document)
            ->once()
            ->andReturn(true);
        $result = $this->documentController->unmark($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testUnmarkFunctionUnauthorized()
    {
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $document->setRelation('uploadBy', $user);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->expectException(AuthorizationException::class);
        $result = $this->documentController->unmark($document->id);
        $this->assertEquals(route('user.documents.index'), $result->getTargetUrl());
    }

    public function testCommentFunctionSuccess()
    {
        $request = new CommentRequest();
        $request->comment = "test comment";
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $author = factory(User::class)->make();
        $author->id = 2;
        $document->setRelation('uploadBy', $author);
        $document->id = 1;
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->userMock
            ->shouldReceive('comment')
            ->with($user, $request->comment, $document)
            ->once()
            ->andReturn(true);
        $result = $this->documentController->comment($request, $document->id);
        $this->assertEquals(route('user.documents.show', ['document' => $document->id]), $result->getTargetUrl());
    }

    public function testCommentFunctionUnauthorized()
    {
        $request = new CommentRequest();
        $request->comment = "test comment";
        $document = factory(Document::class)->make();
        $user = factory(User::class)->make();
        $user->id = 1;
        $document->setRelation('uploadBy', $user);
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->expectException(AuthorizationException::class);
        $result = $this->documentController->comment($request, $document->id);
        $this->assertEquals(route('user.documents.show', ['document' => $document->id]), $result->getTargetUrl());
    }
    public function testDownloadFunctionFree()
    {
        Storage::fake('local');
        $user = factory(User::class)->make();
        $user->id = 1;
        $author = factory(User::class)->make();
        $author->id = 2;
        $document = factory(Document::class)->make();
        $document->setRelation('uploadBy', $author);
        $file = UploadedFile::fake()->create($document->url);
        $file->move('public', $file->getClientOriginalName());
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->documentMock
            ->shouldReceive('getAuthor')
            ->once()
            ->andReturn($author);
        $this->userMock
            ->shouldReceive('download')
            ->with($user, $document)
            ->andReturn(true);
        $this->userMock->shouldReceive('update')
            ->andReturn($user);
        $this->userMock->shouldReceive('update')->with($author->id, [
            'coin' => 1,
        ]);
        $result = $this->documentController->download($document->id);
        $this->assertEquals($result->getFile()->getFilename(), $document->url);
    }

    public function testDownloadFunctionByCoin()
    {
        Storage::fake('local');
        $document = factory(Document::class)->make();
        $document->user_id = 2;
        $document->id = 1;
        $file = UploadedFile::fake()->create($document->url);
        $file->move('public', $file->getClientOriginalName());
        $user = factory(User::class)->make();
        $author = factory(User::class)->make();
        $author->id = 2;
        $document->setRelation('uploadBy', $author);
        $user->id = 1;
        $user->download_free = 0;
        $user->coin = 10;
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->documentMock
            ->shouldReceive('getAuthor')
            ->once()
            ->andReturn($author);
        $this->userMock
            ->shouldReceive('download')
            ->with($user, $document)
            ->andReturn(true);
        $this->userMock->shouldReceive('update')
            ->andReturn($user);
        $this->userMock->shouldReceive('update')
            ->andReturn($author);
        $result = $this->documentController->download($document->id);
        $this->assertEquals($result->getFile()->getFilename(), $document->url);
    }

    public function testDownloadFunctionOutOfCoin()
    {
        Storage::fake('public');
        $document = factory(Document::class)->make();
        $document->user_id = 2;
        $document->id = 1;
        $filename = substr($document->url, 12);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        UploadedFile::fake()->create($filename)
            ->storeAs('uploads/' . $ext, $filename);
        $user = factory(User::class)->make();
        $author = factory(User::class)->make();
        $author->id = 2;
        $user->id = 1;
        $user->download_free = 0;
        $user->coin = 0;
        $this->be($user);
        $this->documentMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($document);
        $this->documentMock
            ->shouldReceive('getAuthor')
            ->once()
            ->andReturn($author);
        $result = $this->documentController->download($document->id);
        $this->assertEquals(route('buy-coin'), $result->getTargetUrl());
    }

    public function testListDocumentsFunction()
    {
        $category = factory(Category::class)->make();
        $category->id = 1;
        $this->categoryMock
            ->shouldReceive('getDocumentsByCategory')
            ->once()
            ->andReturn(new Collection());
        $this->categoryMock
            ->shouldReceive('getChildCategoriesFromRoot')
            ->once()
            ->andReturn(new Collection());
        $result = $this->documentController->listDocuments($category->id);
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('user.documents.search', $result->getName());
        $this->assertArrayHasKey('documents', $data);
        $this->assertArrayHasKey('categories', $data);
    }
}
