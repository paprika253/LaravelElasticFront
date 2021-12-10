<?php

namespace Niocncn\ElasticFront;

use Elasticsearch\ClientBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ElasticFrontClient{

    public static function wpClient($wpAuth,$wpAdminUrl)
    {
        return Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => 'Basic ' . base64_encode($wpAuth)
        ])->baseUrl($wpAdminUrl . '/wp-json/wp/v2/');
    }

    public $client;

    public function __construct($elasticHosts)
    {
        $this->client = ClientBuilder::create()
            ->setHosts($elasticHosts)
            ->build();
    }

    public function delete($model,$entity)
    {
        $params = [
            'index' => $model::$elasticIndex,
            'id'    => $entity['id'],
        ];

        if(! $this->client->exists($params)) return ['errors' => false];

        return $this->client->delete($params);
    }

    public function index($model,$item)
    {
        return $this->bulkEntityUpload($model,[$item]);
    }

    /**
     * @param $model
     * @param $items
     * @return array|callable
     */
    public function bulkEntityUpload($model,$items)
    {
        $params = [
            'client' => [
                'timeout' => 20,
                'connect_timeout' => 20
            ],
            'body' => []
        ];
        foreach ($items as $item){
            $item = $model::prepareFrontElastic($item);
            $params['body'][] = [
                'index' => [
                    '_index' => $model::$elasticIndex,
                    '_id'    => $item['id']
                ]
            ];
            $params['body'][] = $item;
        }
        return ($this->client->bulk($params));
    }

    /**
     * @param $name
     * @return bool
     */
    public function checkIndex($name)
    {
        return $this->client->indices()->exists([
            'index' => $name
        ]);
    }

    /**
     * @param $name
     * @return array
     */
    public function deleteIndex($name)
    {
        return $this->client->indices()->delete([
            'index' => $name
        ]);
    }

    /**
     * @param $name
     * @return array
     */
    public function createIndex($name,$body = null)
    {
        return $this->client->indices()->create([
            'index' => $name,
            'body' => $body
        ]);
    }
}
