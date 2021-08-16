<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository\DocumentRepositoryInterface;
use Session;
use App\Repositories\Category\CategoryRepositoryInterface;

class HomeController extends Controller
{
    protected $cateRepo;

    protected $documentRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepositoryInterface $cateRepo, DocumentRepositoryInterface $documentRepo)
    {
        $this->cateRepo = $cateRepo;
        $this->documentRepo = $documentRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories =  $this->cateRepo->getCategoriesRoot();
        $mostDownloads = $this->documentRepo->getMostDownloads();
        $newDocuments = $this->documentRepo->getNewUploads();

        return view('user.home', compact('categories', 'mostDownloads', 'newDocuments'));
    }

    public function changeLanguage($locale)
    {
        Session::put('language', $locale);

        return redirect()->back();
    }
}
