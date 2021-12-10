<?php

namespace Niocncn\ElasticFront;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ElasticPagination extends LengthAwarePaginator{

    public function url($page)
    {

        if( ! in_array('page',request()->route()->parameterNames)){
            $path = $this->path();
            $parameters = [$this->pageName => $page];
            if (count($this->query) > 0) {
                $parameters = array_merge($this->query, $parameters);
            }
        }else{
            $parameters = count($this->query) > 0 ? $this->query : [];
            $route = request()->route();
            $route->setParameter('page',((int) $page) > 1 ? $page : null);
            $path = (route($route->getName(),$route->parameters));
        }

        if(count($parameters) > 0) $path .=  ( Str::contains($path, '?') ? '&' : '?') . Arr::query($parameters);

        return $path . $this->buildFragment();
    }
}
