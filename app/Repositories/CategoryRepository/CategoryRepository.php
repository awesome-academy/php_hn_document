<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getCategoriesRoot()
    {
        $categories = $this->model->where('parent_id', '=', config('uploads.category_root'))
            ->with('categories')
            ->get();

        return $categories;
    }

    public function getAll()
    {
        $categories = $this->model->with('parent', 'childCategories')
            ->get();

        return $categories;
    }

    public function getChildCategories()
    {
        $categories = $this->model->where('parent_id', '=', config('uploads.category_root'))
            ->with('childCategories')
            ->get();

        return $categories;
    }

    public function countChildCategories($category)
    {
        return $category->childCategories->count();
    }

    public function updateChildCategoriesParent($category, $attribute = [])
    {
        return $category->childCategories()->update($attribute);
    }

    public function updateDocumentsCategory($category, $attribute = [])
    {
        return $category->documents()->update($attribute);
    }
}
