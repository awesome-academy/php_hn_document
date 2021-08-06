<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getCategoriesRoot();

    public function countChildCategories($category);

    public function updateChildCategoriesParent($category, $attribute = []);

    public function updateDocumentsCategory($category, $attribute = []);

    public function getChildCategoriesFromRoot();

    public function getDocumentsByCategory($id);
}
