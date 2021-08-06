<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Requests\CommentRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Document\DocumentRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    protected $documentRepository;
    protected $userRepository;
    protected $categoryRepository;

    public function __construct(
        UserRepositoryInterface $user,
        CategoryRepositoryInterface $category,
        DocumentRepositoryInterface $document
    ) {
        $this->userRepository = $user;
        $this->categoryRepository = $category;
        $this->documentRepository = $document;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = $this->userRepository->ownDocuments(Auth::user());
        $favoriteDocuments = $this->userRepository->favoriteDocument(Auth::user());
        $categories = $this->categoryRepository->getChildCategoriesFromRoot();

        return view('user.documents.list-document', compact('documents', 'favoriteDocuments', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $document = $this->documentRepository->find($id);
        $categories = $this->categoryRepository->getChildCategoriesFromRoot();
        if ($document) {
            $author = $this->documentRepository->getAuthor($document);
            $comments = $this->documentRepository->getComments($document);

            return view('user.documents.show', compact('document', 'author', 'comments', 'categories'));
        } else {
            return view('user.not-found', compact('categories'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = $this->documentRepository->find($id);
        $this->authorize('delete', $document);
        $this->documentRepository->delete($id);

        return redirect()->route('user.documents.index');
    }

    public function upload()
    {
        $categories = $this->categoryRepository->getChildCategoriesFromRoot();

        return view('user.documents.upload', compact('categories'));
    }

    public function storeUpload(DocumentRequest $request)
    {
        $user = Auth::user();
        if ($user->upload <= 0) {
            $message = __('uploads.expired_times');

            return redirect()->route('user.documents.upload')->with('error', $message);
        } else {
            $file = $request->file('file');
            $category = ($request->category == '') ? config('uploads.category_root') : $request->category;
            $url = $this->documentRepository->saveFile($file);
            $attributes = [
                'name' => $request->name,
                'description' => $request->description,
                'url' => $url,
                'user_id' => $user->id,
                'category_id' => $category,
            ];
            $this->documentRepository->create($attributes);
            $upload = $user->upload - 1;
            $coin = $user->coin + 10;
            $this->userRepository->update($user->id, [
                'upload' => $upload,
                'coin' => $coin,
            ]);
            $message = __('uploads.success');

            return redirect()->route('user.documents.upload')->with('success', $message);
        }
    }


    public function search(Request $request)
    {
        $documents = $this->documentRepository->search($request->name);
        $categories = $this->categoryRepository->getChildCategoriesFromRoot();

        return view('user.documents.search', compact('documents', 'categories'));
    }

    public function mark($id)
    {
        $document = $this->documentRepository->find($id);
        $this->authorize('mark', $document);
        $this->userRepository->mark(Auth::user(), $document);

        return redirect()->route('user.documents.index');
    }

    public function unmark($id)
    {
        $document = $this->documentRepository->find($id);
        $this->authorize('mark', $document);
        $this->userRepository->unmark(Auth::user(), $document);

        return redirect()->route('user.documents.index');
    }

    public function download($id)
    {
        $document = $this->documentRepository->find($id);
        $author = $this->documentRepository->getAuthor($document);
        $user = Auth::user();
        if ($user->id != $author->id) {
            if ($user->download_free >= config('user.download_free_least')) {
                $download_free = $user->dowload_free - config('user.download_free_least');
                $this->userRepository->update($user->id, [
                    'download_free' => $download_free
                ]);
            } elseif ($user->coin >= config('user.coin_least')) {
                $coin = $user->coin - config('user.coin_least');
                $this->userRepository->update($user->id, [
                    'coin' => $coin
                ]);
            } else {
                return redirect()->route('buy-coin');
            }
            $this->userRepository->download($user, $document);
            $coin = $author->coin + config('user.coin_author');
            $this->userRepository->update($author->id, [
                'coin' => $coin
            ]);
        }
        $filename = substr($document->url, 12);

        return response()->download(public_path($document->url), $filename);
    }

    public function comment(CommentRequest $request, $id)
    {
        $document = $this->documentRepository->find($id);
        $this->authorize('comment', $document);
        $this->userRepository->comment(Auth::user(), $request->comment, $document);

        return redirect()->route('user.documents.show', ['document' => $document->id]);
    }

    public function listDocuments($id)
    {
        $documents = $this->categoryRepository->getDocumentsByCategory($id);
        $categories = $this->categoryRepository->getChildCategoriesFromRoot();

        return view('user.documents.search', compact('categories', 'documents'));
    }
}
