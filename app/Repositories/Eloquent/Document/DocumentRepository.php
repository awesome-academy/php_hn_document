<?php

namespace App\Repositories\Eloquent\Document;

use App\Models\Document;
use App\Repositories\EloquentRepository;
use Illuminate\Http\UploadedFile;

class DocumentRepository extends EloquentRepository implements DocumentRepositoryInterface
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
}
