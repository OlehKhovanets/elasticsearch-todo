<?php

namespace App\Services\SearchEngine\ElasticSearch;

use App\Services\SearchEngine\SearchEngineWrapperInterface;
use App\Services\SearchEngine\Strategy;

/**
 * Class ElasticSearchMapping
 * @package App\Services\SearchEngine\ElasticSearch
 *
 * elasticsearch version 7.1.1
 */
class ElasticSearchMapping implements Strategy
{
    protected string $index;
    protected array $properties;
    protected array $params;
    protected SearchEngineWrapperInterface $elastic;

    const NUMBER_OF_SHARDS = 1;
    const NUMBER_OF_REPLICAS = 0;
    const MAX_NGRAM_DIFF = '50';
    const TOKENIZER = 'standard';


    public function __construct(string $index, array $properties)
    {
        $elastic = app(SearchEngineWrapperInterface::class);
        $this->elastic = $elastic;
        $this->index = $index;
        $this->properties = $properties;
        $this->buildMap();
    }

    public function mapping(): void
    {
        $this->elastic->init($this->params);
    }

    public function buildMap(): void
    {
        $this->setIndex()->setBody()->setProperties();
    }

    public function setIndex(): ElasticSearchMapping
    {
        $this->params['index'] = $this->index;
        return $this;
    }

    public function setAnalyzer(): string
    {
        return $this->index;
    }

    public function setProperties(): ElasticSearchMapping
    {
        $properties = [];

        foreach ($this->properties as $property) {
            $properties[$property] = [
                'type' => 'text',
                'analyzer' => $this->setAnalyzer(),
                'copy_to' => 'combined'
            ];
        }

        $this->params['body']['mappings']['properties'] = $properties;
        return $this;
    }

    public function setBody(): ElasticSearchMapping
    {
        $this->params['body']['settings'] = [
            'number_of_shards' => self::NUMBER_OF_SHARDS,
            'number_of_replicas' => self::NUMBER_OF_REPLICAS,
            'max_ngram_diff' => self::MAX_NGRAM_DIFF,
            'analysis' => [
                'filter' => [
                    'shingle' => [
                        'type' => 'shingle'
                    ],
                    $this->index . '_ngram' => [
                        'type' => 'nGram',
                        'min_gram' => 2,
                        'max_gram' => 4
                    ]
                ],
                'analyzer' => [
                    $this->index => [
                        'type' => 'custom',
                        'tokenizer' => self::TOKENIZER,
                        'filter' => [
                            'lowercase',
                            'kstem',
                             $this->index . '_ngram'
                        ]
                    ]
                ]
            ]
        ];
        return $this;
    }

    public function deleteIndex(): void
    {
        $this->elastic->deleteIndex([
            'index' => $this->index,
        ]);
    }
}
