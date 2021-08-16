<?php

namespace App\Repositories\DocumentRepository;

use App\Models\Document;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Imagick;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return Document::class;
    }

    public function search($name)
    {
        $documents = Document::where('name', 'LIKE', '%' . $name . '%')->with('uploadBy')
            ->paginate(config('user.paginate'));

        return $documents;
    }

    public function getComments($document)
    {
        $comments = $document->comments()->orderBy('comments.created_at', 'desc')->get();

        return $comments;
    }

    public function getAuthor($document)
    {
        return $document->uploadBy;
    }

    public function saveFile($file)
    {
        $filename = $file->getClientOriginalName();
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $path = 'uploads/' . $extension . '/';
        $file->storeAs($path, $filename);

        return $path . $filename;
    }

    public function getDataPerMonth($table, $years)
    {
        $dataMonth = [];
        foreach ($years as $year) {
            $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $data = DB::table($table)
                ->whereYear('created_at', $year->year)
                ->select(array(DB::raw('distinct MONTH(created_at) as month'), DB::raw('count(*) as total')))
                ->groupBy('month')
                ->orderByRaw('MONTH(created_at) asc')
                ->get();
            foreach ($data as $d) {
                $months[--$d->month] = $d->total;
            }
            $dataMonth[$year->year] = $months;
        }

        return $dataMonth;
    }

    public function getMostDownloads()
    {
        $documents = Document::with('category')
            ->withCount(['downloads', 'comments'])
            ->orderBy('downloads_count', 'DESC')
            ->take(config('uploads.documents_per_row'))
            ->get();

        return $documents;
    }

    public function getNewUploads()
    {
        $documents = Document::with('category')
            ->withCount(['downloads', 'comments'])
            ->orderBy('created_at', 'DESC')
            ->take(config('uploads.documents_per_row'))
            ->get();

        return $documents;
    }

    public function getPreviewImages($file, $target)
    {
        $imgExt = new Imagick();
        for ($i = 0; $i <= config('uploads.preview_pages'); $i++) {
            $path = 'uploads/preview/' . $target . "-" . $i . "." . config('uploads.cover_type');
            $imgExt->readImage($file . "[" . $i . "]");
            $imgExt->writeImage($path);
        }
    }
}
