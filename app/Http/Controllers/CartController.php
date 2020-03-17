<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        
        $request = request();

        $product_ids = $request->cookie('cart', []);
        if ($product_ids) {
            $product_ids = unserialize($product_ids);
        }
        $ids = array_keys($product_ids);

        $products = Product::whereIn('id', $ids)->get();
        
        return view('cart', [
            'products' => $products,
            'quantity' => $product_ids,
        ]);
    }


    public function store(Request $request)
    {
        if (Auth::check()) {

        } else {
            $products = $request->cookie('cart', []);
            if ($products) {
                $products = unserialize($products);
            }
            $product_id = $request->post('product_id');
            if (array_key_exists($product_id, $products)) {
                $products[$product_id]++;
            } else {
                $products[$product_id] = 1;
            }

            
            $cookie = Cookie::make('cart', serialize($products), 10080); // One week

            return redirect()->route('cart')
                ->cookie($cookie);
        }
    }

    public function remove($product_id)
    {
        // Delete all cookie!
        /*$cookie = Cookie::make('cart', '', -100); // One week

        return redirect()->route('cart')
            ->cookie($cookie);*/

        $request = request();
        $products = $request->cookie('cart', []);
        if ($products) {
            $products = unserialize($products);
        }
        if (array_key_exists($product_id, $products)) {
            unset($products[$product_id]);
        }

        $cookie = Cookie::make('cart', serialize($products), 10080); // One week

        return redirect()->route('cart')
            ->cookie($cookie);
    }

    public function indexSession()
    {
        $product_ids = session('cart', []);
        //request()->session()->get('cart', []);
        

        $ids = array_keys($product_ids);

        $products = Product::whereIn('id', $ids)->get();
        
        return view('cart', [
            'products' => $products,
            'quantity' => $product_ids,
        ]);
    }

    public function storeSession(Request $request)
    {
        $products = session('cart', []);
        //$products = $request->session()->get('cart', []);
        
        $product_id = $request->post('product_id');
        if (array_key_exists($product_id, $products)) {
            $products[$product_id]++;
        } else {
            $products[$product_id] = 1;
        }
        session([
            'cart' => $products,
        ]);
        //$request()->session()->put('cart', $products);

        return redirect()->route('cart');
    }

    public function removeSession($product_id)
    {
        $products = session('cart', []);
        if (array_key_exists($product_id, $products)) {
            unset($products[$product_id]);
        }
        session([
            'cart' => $products
        ]);

        return redirect()->route('cart');
    }
}
