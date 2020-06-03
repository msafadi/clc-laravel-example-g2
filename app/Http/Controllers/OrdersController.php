<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Events\NewOrder;
use App\Events\OrderCreated;
use App\Notifications\NewOrderNotification;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrdersController extends Controller
{
    public function index()
    {
        return Auth::user()->orders;
    }
    
    public function store()
    {
        $user = Auth::user();
        /*$order = Order::forceCreate([
            'user_id' => $user->id,
        ]);*/
        DB::beginTransaction();

        try {
            $order = $user->orders()->create([
                'status' => 'pending-payment',
                'tax' => '14',
                'discount' => '10',
            ]);

            foreach ($user->cartProducts as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => $product->cart->quantity,
                    'price' => $product->cart->price,
                ]);
            }

            /*foreach ($user->cartProducts as $product) {
                //$user->cartProducts()->detach($product->id);
                
            }*/
            Cart::where('user_id', $user->id)->delete();
            
            DB::commit();

            //event(new NewOrder($order));

            Auth::user()->notify(new NewOrderNotification($order));



            //event(new OrderCreated($order));

        } catch(Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        return redirect()->route('orders')
            ->with('success', 'Order created!');

        /*DB::transaction(function() {
            $order = $user->orders()->create([
                'status' => 'pending-payment',
                'tax' => '14',
                'discount' => '10',
            ]);

            foreach ($user->cartProducts as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => $product->cart->quantity,
                    'price' => $product->cart->price,
                ]);
            }
        });*/

        
    }
}
