<?php

namespace App\Services\SearchEngine\ElasticSearch;

use App\Services\SearchEngine\SearchEngineSearchInterface;
use App\Services\SearchEngine\SearchEngineWrapperInterface;

class ElasticSearchSearch implements SearchEngineSearchInterface
{
    protected array $params;
    protected int $size;
    protected int $from;
    protected string $query;
    protected array $response;


    public function init($size, $form, $query)
    {
        $this->size = $size;
        $this->from = $form;
        $this->query = $query;

        return $this;
    }

    public function buildQuery()
    {
        $params = [
            'size' => $this->size,
            'from' => $this->from,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $this->query,
                        'fields' => ['title', 'description'],
                    ],
                ]
            ]
        ];

        $this->params = $params;

        return $this;
    }

    public function search()
    {
        $elastic = app(SearchEngineWrapperInterface::class);
        $response = $elastic->search($this->params);
        $this->response = $response;

        return $this;
    }

    public function getResponse()
    {
        $result = collect($this->response['hits']['hits'])->transform(function ($item) {
            return [
                'id' => $item['_source']['id'],
                'title' => $item['_source']['title'],
                'description' => $item['_source']['description'],
                'created_at' => $item['_source']['created_at'],
                'updated_at' => $item['_source']['updated_at'],
            ];
        });

        return [
            'result' => $result,
            'total' => $this->response['hits']['total']['value']
        ];
    }
}
