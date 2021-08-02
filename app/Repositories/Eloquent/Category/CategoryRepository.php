<?php

namespace App\Repositories\Eloquent\Category;

use App\Models\Category;
use App\Repositories\EloquentRepository;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return Category::class;
    }

    public function getChildCategoriesFromRoot()
    {
        $categories = Category::where('parent_id', '=', config('uploads.category_root'))
            ->with('childCategories')
            ->get();

        return $categories;
    }

    public function getDocumentsByCategory($id)
    {
        $category = $this->find($id);

        return $category->documents()->paginate(config('user.paginate'));
    }
}
