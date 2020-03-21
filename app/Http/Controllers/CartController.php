<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user) {
            return view('cart', [
                'products' => $user->cartProducts,
            ]);
        }

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
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'int',
        ]);
        $product_id = $request->post('product_id');
        
        $user = Auth::user();

        if ($user) {
            $quantity = $request->post('quantity', 1);
            $price = Product::find($product_id)->price;
            
            Cart::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $product_id],
                [
                    'quantity' => DB::raw('quantity + ' . $quantity), 
                    'price' => $price
                ]
            );

            /*$cart = Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->first();
            if ($cart) {
                $cart->update([
                        'quantity' => $cart->quantity + $request->post('quantity', 1),
                        'price' => Product::find($product_id)->price,
                    ]);
            } else {
                $cart = Cart::forceCreate([
                    'user_id' => $user->id,
                    'product_id' => $product_id,
                    'quantity' => $request->post('quantity', 1),
                    'price' => Product::find($product_id)->price,
                ]);
            }*/

            return redirect()->route('cart');

        } else {
            $products = $request->cookie('cart', []);
            if ($products) {
                $products = unserialize($products);
            }
            
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

    public function update(Request $request)
    {
        $quantity = $request->post('quantity');
        $user = Auth::user();
        if ($user) {
            foreach ($quantity as $pid => $q) {
                $cart = Cart::where([
                    'user_id' => $user->id,
                    'product_id' => $pid
                ]);
                if ($q <= 0) {
                    $cart->delete();
                } else {
                    $cart->update([
                        'quantity' => $q
                    ]);
                }
            }
        }
        return redirect()->route('cart');
    }

    public function remove($product_id)
    {
        $user = Auth::user();
        if ($user) {
            Cart::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->delete();
            return redirect()->route('cart');
        }

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
