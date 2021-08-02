<?php

namespace App\Repositories\Eloquent\User;

use App\Models\User;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return User::class;
    }

    public function mark($user, $document)
    {
        $user->favorites()->attach($document);

        return true;
    }

    public function unmark($user, $document)
    {
        $user->favorites()->detach($document);

        return true;
    }

    public function download($user, $document)
    {
        $user->downloads()->attach($document);

        return true;
    }

    public function comment($user, $content, $document)
    {
        $user->comments()->attach($document, ['content' => $content]);

        return true;
    }

    public function favoriteDocument($user)
    {
        return $user->favorites()->paginate(config('user.paginate'));
    }

    public function ownDocuments($user)
    {
        return $user->documents()->paginate(config('user.paginate'));
    }
}
