<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasCompositeKeys
{

    protected function setKeysForSaveQuery(Builder $query)
    {
        foreach ($this->getKeyName() as $key) {
            $query->where($key, $this->getAttribute($key));
        }
        return $query;
    }
    
}