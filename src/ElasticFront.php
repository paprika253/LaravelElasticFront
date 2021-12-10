<?php

namespace Niocncn\ElasticFront;

use Niocncn\ElasticFront\Traits\ModelQuery;
use Niocncn\ElasticFront\Traits\RelationsTrait;
use Illuminate\Contracts\Support\Arrayable;
use ArrayAccess;

abstract class ElasticFront implements Arrayable, ArrayAccess {

    use RelationsTrait, ModelQuery;

    protected $client;
    public static $elasticIndex;
    public static $wpEntity;
    public static $searchFields = [];
    public $scopes = [];

    public static abstract function prepareFrontElastic(array $model) : array;
    public static abstract function elasticIndexSettings() : array;

    /** @var bool При рилейшенах загружать полностью весь список */
    protected $preloadFull = true;

    public function elasticHosts() : array
    {
        return [];
    }

    public static function query() : ElasticQuery
    {
        return (new static)->newQuery();
    }

    public function newQuery() : ElasticQuery
    {
        return new ElasticQuery($this);
    }

    public function relatedTo($className) : ElasticFront
    {
        return new $className();
    }

}
