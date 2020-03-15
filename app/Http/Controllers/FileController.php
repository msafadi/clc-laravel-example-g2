<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function download($id)
    {
        $product = Product::findOrFail($id);
        $path = storage_path('app/public/' . $product->image);
        return response()
            ->download($path, $product->name);
    }

    public function view($id)
    {
        
        $product = Product::findOrFail($id);
        $path = storage_path('app/public/' . $product->image);
        return response()
            ->file($path);
    }
}
