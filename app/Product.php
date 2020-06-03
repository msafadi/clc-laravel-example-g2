<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    //
    protected $fillable = ['name', 'description', 'category_id', 'image', 'price'];

    protected $hidden = [
        //'price',
    ];

    protected $appends = [
        'category_name', 'full_name'
    ];

    protected static function boot()
    {
        parent::boot();

        /*static::addGlobalScope('vip', function(Builder $builder) {
            return $builder->where('price', '>=', 300);
        });*/

        static::deleting(function($model) {
            $count = OrderProduct::where('product_id', $model->id)->count();
            if ($count > 0) {
                throw new Exception('Cannot delete product has orders!');
            }
        });
    }

    public function scopePrice(Builder $builder, $price, $price2 = 0)
    {
        $builder->where('price', '>=', $price);
        if ($price2) {
            $builder->where('price', '<=', $price2);
        }
        return $builder;
    }

    public function getCategoryNameAttribute()
    {
        return '';
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')
            ->withDefault([
                'name' => 'No Category',
            ]);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, 
            'products_tags', 
            'product_id', 
            'tag_id',
            'id',
            'id'
        );
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->using(OrderProduct::class);
    }

    public function getSimilar($limit = 4, $order = 'created_at', $sort = 'DESC')
    {
        $tags = $this->tags()->pluck('id')->toArray();
        if (!$tags) {
            return [];
        }
        $tag_ids = implode(',', $tags);

        $similar_prdoucts = Product::whereRaw("id IN (SELECT product_id FROM products_tags WHERE tag_id IN ($tag_ids))")
            ->where('id', '<>', $this->id)
            ->limit($limit)
            ->inRandomOrder()
            ->get();

        return $similar_prdoucts;
    }
}
