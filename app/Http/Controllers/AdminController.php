<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository\DocumentRepositoryInterface;
use App\Repositories\ReceiptRepository\ReceiptRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

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

    public function documentList()
    {
        return view('admin.documents.list');
    }

    public function getDocuments()
    {
        $documents = $this->documentRepository->getData();

        return Datatables::of($documents)
            ->addIndexColumn()
            ->addColumn(__('document.cover'), function ($document) {
                $image = asset('uploads/preview/' . $document->name . '-' .
                    config('uploads.cover_page') . '.' . config('uploads.cover_type'));
                return '<img src="' . $image . '" class="img-fluid" width="90" height="90">';
            })
            ->addColumn(__('document.restore'), function ($document) {
                return '<input id="urlRestore" type="hidden" value="' .
                    route('admin.documents.restore', $document->id) . '">
                        <button type="submit" class="btn btn-outline-success btnRestore">
                        <i class="fas fa-trash-restore"></i></button>';
            })
            ->addColumn(__('document.delete'), function ($document) {
                return '<input id="urlDelete" type="hidden" value="' .
                    route('admin.documents.soft-delete', $document->id) . '">
                        <button type="submit" class="btn btn-outline-danger btnDelete">
                        <i class="fas fa-trash"></i></button>';
            })
            ->rawColumns([__('document.cover'), __('document.restore'), __('document.delete')])
            ->make(true);
    }

    public function deleteDocument($id)
    {
        $isSuccess = $this->documentRepository->delete($id);
        $status = config('code.server_error');
        $title = __('document.deleted_error');
        $message = __('document.deleted_error_mess');
        if ($isSuccess) {
            $title = __('document.deleted_success');
            $message = __('document.deleted_success_mess');
            $status = config('code.success');
        }

        return response()->json([
            'message' => $message,
            'title' => $title,
        ], $status);
    }

    public function restoreDocument($id)
    {
        $isSuccess = $this->documentRepository->restore($id);
        $status = config('code.server_error');
        $title = __('document.restore_error');
        $message = __('document.restore_error_mess');
        if ($isSuccess) {
            $title = __('document.restore_success');
            $message = __('document.restore_success_mess');
            $status = config('code.success');
        }

        return response()->json([
            'message' => $message,
            'title' => $title,
        ], $status);
    }
}
