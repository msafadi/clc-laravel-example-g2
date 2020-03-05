<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name', 'description', 'category_id', 'image', 'price'];

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
}
