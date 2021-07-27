<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('parent', 'childCategories')
            ->get();

        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', '=', config('uploads.category_root'))
            ->with('childCategories')
            ->get();

        return view('admin.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $parentId = ($request->category ?? config('uploads.category_root'));
        $category->create([
            'name' => $request->name,
            'parent_id' => $parentId,
        ]);
        $message = __('category.create_success');

        return redirect(route('admin.categories.index'))->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('parent_id', '=', config('uploads.category_root'))
            ->with('childCategories')
            ->get();

        $thisCategory = Category::findOrFail($id);
        $parent = $thisCategory->parent;

        return view('admin.categories.edit', compact('thisCategory', 'parent', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->category,
        ]);
        $message = __('category.update_success');

        return redirect(route('admin.categories.index'))->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $status = config('code.server_error');
        $title = __('category.error');
        $message = __('category.delete_error');
        if ($category) {
            $childCategories = $category->childCategories;
            if ($childCategories->count() > 0) {
                $category->childCategories()->update([
                    'parent_id' => config('uploads.category_root'),
                ]);
            }
            if ($category->delete()) {
                $title = __('category.success');
                $message = __('category.delete_success');
                $status = config('code.success');
            } else {
                $status = config('code.client_error');
            }
        }

        return response()->json([
            'message' => $message,
            'title' => $title,
        ], $status);
    }
}
