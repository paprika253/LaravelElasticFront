<?php

namespace Niocncn\ElasticFront\Traits;

trait SearchQueryTrait{

    /**
     * @param $match
     * @param array $fields
     * @return $this
     */
    public function searchRelevant($match, array $fields = []) : self
    {
        if(empty($fields) && $this->model::$searchFields) $fields = $this->model::$searchFields;
        $this->sort(null);
        $this->must([
            "function_score" => [
                "functions" => [
                    [
                        "gauss" => [
                            "date" => [
                                "scale" => "360d"
                            ]
                        ]
                    ]
                ],
                "query" => [
                    "multi_match" => [
                        "query" => $match,
                        "fields" => $fields,
                        "fuzziness" => "AUTO",
                        "tie_breaker" => 0.3
                    ]
                ]
            ]
        ]);
        return $this;
    }
}
