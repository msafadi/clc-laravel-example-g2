@extends('layouts.home')

@section('content')

<!-- cart-main-area start -->
<div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="{{ route('cart.update') }}" method="post">
                            @csrf
                            @method('put')              
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                        @php
                                            if (isset($quantity[$product->id])) {
                                                $q = $quantity[$product->id];
                                                $price = $product->price;
                                            } else {
                                                $q = $product->cart->quantity;
                                                $price = $product->cart->price;
                                            }

                                        @endphp
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="{{ route('file', [$product->id]) }}" alt="product img" /></a></td>
                                            <td class="product-name"><a href="#">{{ $product->name }}</a>
                                                <ul  class="pro__prize">
                                                    <li class="old__prize">${{ $product->price }}</li>
                                                    <li>${{ $product->price }}</li>
                                                </ul>
                                            </td>
                                            <td class="product-price"><span class="amount">${{ $product->price }}</span></td>
                                            <td class="product-quantity"><input type="number" value="{{ $q }}" name="quantity[{{ $product->id }}]" min="0"></td>
                                            <td class="product-subtotal">{{ $product->price * $q }}$</td>
                                            <td class="product-remove"><a href="{{ route('cart.remove', [$product->id]) }}"><i class="icon-trash icons"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="#">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                            <button type="submit">update</button>
                                            <a href="{{ route('orders.store') }}">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="ht__coupon__code">
                                        <span>enter your discount code</span>
                                        <div class="coupon__box">
                                            <input type="text" placeholder="">
                                            <div class="ht__cp__btn">
                                                <a href="#">enter</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 smt-40 xmt-40">
                                    <div class="htc__cart__total">
                                        <h6>cart total</h6>
                                        <div class="cart__desk__list">
                                            <ul class="cart__desc">
                                                <li>cart total</li>
                                                <li>tax</li>
                                                <li>shipping</li>
                                            </ul>
                                            <ul class="cart__price">
                                                <li>$909.00</li>
                                                <li>$9.00</li>
                                                <li>0</li>
                                            </ul>
                                        </div>
                                        <div class="cart__total">
                                            <span>order total</span>
                                            <span>$918.00</span>
                                        </div>
                                        <ul class="payment__btn">
                                            <li class="active"><a href="#">payment</a></li>
                                            <li><a href="#">continue shopping</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->

@endsection