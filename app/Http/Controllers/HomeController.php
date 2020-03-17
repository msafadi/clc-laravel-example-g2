<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slider_products = Product::with('category')->latest()->limit(2)->get(); // orderBy('created_at', 'DESC')
        $new_arrivals = Product::latest()->limit(8)->get();
        return view('home', [
            'slider_products' => $slider_products,
            'new_arrivals' => $new_arrivals,
            'online_visitors' => DB::table('sessions')->count(),
        ]);
    }
}
