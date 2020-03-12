<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        //$similar_prdoucts = $product->getSimilar();

        return view('product-details', [
            'product' => $product,
            //'similar_prdoucts' => $similar_prdoucts,
        ]);
    }
}
