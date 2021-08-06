<?php

namespace App\Repositories\Document;

use App\Repositories\RepositoryInterface;

interface DocumentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function search($name);

    /**
     * @param $document
     * @return mixed
     */
    public function getComments($document);

    /**
     * @param $document
     * @return mixed
     */
    public function getAuthor($document);

    /**
     * @param $file
     * @return mixed
     */
    public function saveFile($file);
}
