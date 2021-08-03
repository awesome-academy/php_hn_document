<?php

namespace App\Repositories\Eloquent\User;

interface UserRepositoryInterface
{
    /**
     * @param $user
     * @param $document
     * @return mixed
     */
    public function mark($user, $document);

    /**
     * @param $user
     * @param $document
     * @return mixed
     */
    public function unmark($user, $document);

    /**
     * @param $user
     * @param $document
     * @return mixed
     */
    public function download($user, $document);

    /**
     * @param $user
     * @param $content
     * @param $document
     * @return mixed
     */
    public function comment($user, $content, $document);

    /**
     * @param $user
     * @return mixed
     */
    public function favoriteDocument($user);

    /**
     * @param $user
     * @return mixed
     */
    public function ownDocuments($user);
}
