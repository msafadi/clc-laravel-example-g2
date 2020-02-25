<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // List all categories
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::all(),
        ]);
    }

    // Show create form
    public function create()
    {
        return view('admin.categories.create');
    }

    // Create category on form submit
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->post('name'); //$request->input('name'); //$request->get('name'); //$request->name;
        $category->description = $request->post('description');
        $category->parent_id = $request->post('parent_id');
        $category->save();

        
        //return redirect(route('categories'));
        return redirect()->route('categories');
    }

    // Show edit form
    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }

        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    // Update category on form submit
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->post('name');
        $category->description = $request->post('description');
        $category->parent_id = $request->post('parent_id');
        $category->save();

        return redirect()->route('categories');
        
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories');
    }
}
