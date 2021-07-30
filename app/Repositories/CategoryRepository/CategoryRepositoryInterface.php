<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getCategoriesRoot();

    public function getChildCategories();

    public function countChildCategories($category);

    public function updateChildCategoriesParent($category, $attribute = []);

    public function updateDocumentsCategory($category, $attribute = []);
}
