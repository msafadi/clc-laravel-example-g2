<?php

namespace App;

use App\Traits\HasCompositeKeys;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Cart extends Pivot
{
    use HasCompositeKeys;
    
    protected $table = 'carts';

    protected $fillable = ['user_id', 'product_id', 'quantity', 'price'];

    protected $primaryKey = ['user_id', 'product_id'];

    public $incrementing = false;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
