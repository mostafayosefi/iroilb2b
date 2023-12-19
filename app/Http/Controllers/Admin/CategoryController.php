<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\CategoryCollection;

class CategoryController extends Controller
{
    // show all categories
    public function index()
    {
        $categories = Category::with('parent')->whereNull('parent_id')->get();
        $cat = [];
        foreach ($categories as $item => $kay) {
            $cat[$item]['id'] = $kay['id'];
            $cat[$item]['slug'] = $kay['slug'];
            $cat[$item]['titleEn'] = $kay['title_en'];
            $cat[$item]['titleFa'] = $kay['title_fa'];
            $cat[$item]['descriptionEn'] = $kay['description_en'];
            $cat[$item]['descriptionFa'] = $kay['description_fa'];
        }

        $subcategories = Category::with('parent')->whereNotNull('parent_id')->get();
        $subCat = [];
        foreach ($subcategories as $item => $kay) {
            $subCat[$item]['id'] = $kay['id'];
            $subCat[$item]['slug'] = $kay['slug'];
            $subCat[$item]['parentId'] = $kay['parent_id'];
            $subCat[$item]['titleEn'] = $kay['title_en'];
            $subCat[$item]['titleFa'] = $kay['title_fa'];
            $subCat[$item]['descriptionEn'] = $kay['description_en'];
            $subCat[$item]['descriptionFa'] = $kay['description_fa'];
        }

        return response()->json([
            'cat' => $cat,
            'subCat' => $subCat
        ], 200);
    }

    // delete admin categories
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['status' => 200], 200);
    }

    // get admin category
    public function edit($id)
    {
        $category = new CategoryCollection(Category::find($id));
        return response()->json($category, 200);
    }

    // store admin category
    public function store(Request $request)
    {
        $category = new Category([
            'slug' => $request->get('slug'),
            'parent_id' => $request->get('parent_id'),
            'title_en' => $request->get('title_en'),
            'title_fa' => $request->get('title_fa'),
            'description_en' => $request->get('description_en'),
            'description_fa' => $request->get('description_fa')
        ]);
        $category->save();
        return response()->json('success', 200);
    }

    // update admin category
    public function update($id, Request $request)
    {
        $category = Category::find($id);
        $category->slug = $request->get('slug');
        $category->parent_id = $request->get('parent_id');
        $category->title_en = $request->get('title_en');
        $category->title_fa = $request->get('title_fa');
        $category->description_en = $request->get('description_en');
        $category->description_fa = $request->get('description_fa');
        $category->save();
        return response()->json('successfully updated', 200);
    }

}
