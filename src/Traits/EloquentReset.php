<?php

namespace Niocncn\ElasticFront\Traits;

trait EloquentReset{

    /**
     * @return false
     */
    public function usesTimestamps()
    {
        return false;
    }

    /**
     * @return false
     */
    public function getIncrementing(){
        return false;
    }
}
