<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $perpage = $request->query('perpage');
        if ($perpage == 'all') {
            // Select * from products
            // select * from categories where id IN (1, 2, 3)
            $products = Product::with('category', 'tags')->get();
            
            /*$products = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->select([
                    'products.*',
                    'categories.name as category_name',
                ])
                ->get();*/
            
        } else {
            $products = Product::with('category', 'tags')->paginate($perpage);
        }

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category_id' => 'required|int|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'image' => 'required|image|dimensions:min_width=200,min_height=200',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the uploaded file in the public disk
            // (storage/app/public) and return its path
            $image = $request->file('image')->store('images', 'public');
            
            /*$file = $request->file('image');
            $filename = 'product-image-' . date('Y-m-d-H-i-s');
            // $filename = $file->getClientOriginalName();
            $image = $file->storeAs('images', $filename, 'public');*/
        }

        $data = array_merge($request->all(), [
            'image' => $image,
        ]);

        $product = Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', "Product {$product->name} created!");
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
        $product = Product::findOrFail($id);
        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);
        return view('admin.products.edit', [
            'product' => $product,
        ]);
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
        $request->validate([
            'category_id' => 'required|int|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'image' => 'image|dimensions:min_width=200,min_height=200',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        $image = $product->image;
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the uploaded file in the public disk
            // (storage/app/public) and return its path
            $image = $request->file('image')->store('images', 'public');
            
            /*$file = $request->file('image');
            $filename = 'product-image-' . date('Y-m-d-H-i-s');
            // $filename = $file->getClientOriginalName();
            $image = $file->storeAs('images', $filename, 'public');*/

            // Delete old image
            Storage::disk('public')->delete($product->image);
        }

        $data = array_merge($request->all(), [
            'image' => $image,
        ]);

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', "Product {$product->name} updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();

        // Delete the product file
        Storage::disk('public')->delete($product->image);

        return redirect()
            ->route('products.index')
            ->with('success', "Product {$product->name} deleted!");
    }
}
