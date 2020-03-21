<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->using(OrderProduct::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($order) {
            //dd($order);
        });
    }
}
