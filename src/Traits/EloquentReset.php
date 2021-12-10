<?php

namespace Niocncn\ElasticFront\Traits;

trait EloquentReset{

    public function usesTimestamps()
    {
        return false;
    }

    public function getIncrementing(){
        return false;
    }
}
