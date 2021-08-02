<?php

namespace App\Repositories\Eloquent\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getChildCategoriesFromRoot();

    /**
     * @param $id
     * @return mixed
     */
    public function getDocumentsByCategory($id);
}
