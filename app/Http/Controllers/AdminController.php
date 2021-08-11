<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository\DocumentRepositoryInterface;
use App\Repositories\ReceiptRepository\ReceiptRepositoryInterface;

class AdminController extends Controller
{
    protected $documentRepository;
    protected $receiptRepository;
    public function __construct(
        DocumentRepositoryInterface $document,
        ReceiptRepositoryInterface $receipt
    ) {
        $this->documentRepository = $document;
        $this->receiptRepository = $receipt;
    }

    public function index()
    {
        $year_coin = $this->receiptRepository->getYearsStatistic('receipts');
        $year_download = $this->documentRepository->getYearsStatistic('downloads');
        $year_upload = $this->documentRepository->getYearsStatistic('documents');
        $downloadMonth = $this->documentRepository->getDataPerMonth('downloads', $year_download);
        $uploadMonth = $this->documentRepository->getDataPerMonth('documents', $year_upload);
        $coinMonth = $this->receiptRepository->getCoinsPerMonth($year_coin);
        $years = array_unique(array_merge(array_keys($uploadMonth), array_keys($downloadMonth)));

        return view('admin.index', [
            'downloadMonth' => $downloadMonth,
            'uploadMonth' => $uploadMonth,
            'coin' => $coinMonth,
            'years' => $years,
            'year_coin' => $year_coin,
        ]);
    }
}
