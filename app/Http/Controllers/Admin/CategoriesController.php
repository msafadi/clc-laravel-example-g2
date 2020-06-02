<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => 'required|string|max:255|min:3',
        'description' => 'nullable|string|max:2000',
        'parent_id' => 'nullable|int|exists:categories,id',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    // List all categories
    public function index($id = null)
    {
        $this->authorize('view-any', Category::class);
        //dd(Gate::forUser($user)->allows('view-category'));

        if ($id) {
            // If there's a category ID we will fetch all its children!
            $category = Category::findOrFail($id);
            //$categories = Category::where('parent_id', '=', $id)->get();
            $categories = $category->children()->with('parent')->get();
        } else {
            // Get all root categories (no parent)
            // Where parent_id IS NULL
            $categories = Category::whereNull('parent_id')->with('parent')->get();
            $category = null;
        }
        return view('admin.categories.index', [
            'categories' => $categories,
            'parent' => $category,
        ]);
    }

    // Show create form
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('admin.categories.create');
    }

    // Create category on form submit
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        // Validate request directly!
        $request->validate($this->rules);
        
        // Create a validator 
        /*$validator = Validator::make($request->all(), $this->rules, [], [
            'name' => 'Category name',
            'parent_id' => 'Category parent',
        ]);
        $validator->validate();*/
        /*if ($validator->fails()) {
            return redirect()
                ->back() // Redirect to previous route (back)
                ->withErrors($validator) // Send the validation errors
                ->withInput($request->all()); // Send the current request input
        }*/

        // Method 1: Create an empty model
        /*$category = new Category();
        $category->name = $request->post('name'); //$request->input('name'); //$request->get('name'); //$request->name;
        $category->description = $request->post('description');
        $category->parent_id = $request->post('parent_id');
        $category->save();*/

        // Method 2: Create by mass assignment
        $category = Category::create($request->all());

        
        $message = sprintf('%s created!', $category->name);
        return redirect()
            ->route('categories')
            ->with('success', $message); // With flash message!
    }

    // Show edit form
    public function edit($id)
    {
        $category = Category::find($id);
        $this->authorize('update', $category);
        
        /*$user = Auth::user();
        if (!$user->can('update', $category)) {
            return view('');
        }*/

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
        $request->validate($this->rules);

        // Update directly!
        //Category::where('id', $id)->update($request->all());

        // Get the category model and then update!
        $category = Category::findOrFail($id);
        $this->authorize('update', $category);

        // Method 1: Mass assignment
        $category->update($request->all());
        
        // Method 2: Update per by property assignment
        /*$category->name = $request->post('name');
        $category->description = $request->post('description');
        $category->parent_id = $request->post('parent_id');
        $category->save();*/

        $message = sprintf('%s updated!', $category->name);
        return redirect()
            ->route('categories')
            ->with('success', $message); // Flash Message!
        
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('delete', $category);
        $category->delete();

        $message = sprintf('%s deleted!', $category->name);
        return redirect()
            ->route('categories')
            ->with('success', $message);
    }

}
