<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Document $document)
    {
        $author = $document->uploadBy;

        return $user->id === $author->id;
    }

    public function mark(User $user, Document $document)
    {
        $author = $document->uploadBy;

        return $user->id !== $author->id;
    }

    public function comment(User $user, Document $document)
    {
        $author = $document->uploadBy;

        return $user->id !== $author->id;
    }
}
