<?php

namespace App\Repositories\DocumentRepository;

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

    /**
     * @param $years
     * @param $table
     * @return mixed
     */
    public function getDataPerMonth($table, $years);

    /**
     * @return mixed
     */
    public function getMostDownloads();

    /**
     * @return mixed
     */
    public function getNewUploads();

    /**
     * @return mixed
     */
    public function getPreviewImages($file, $target);
}
