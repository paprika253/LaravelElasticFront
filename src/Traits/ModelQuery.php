<?php
namespace Niocncn\ElasticFront\Traits;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Support\Traits\ForwardsCalls;

trait ModelQuery{

    use HasAttributes, HasRelationships, EloquentReset, ForwardsCalls;

    public function offsetExists($offset)
    {
        return ! is_null($this->getAttribute($offset));
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function __unset($key)
    {
        $this->offsetUnset($key);
    }


    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    public function toArray()
    {
        return $this->attributesToArray();
    }


}
