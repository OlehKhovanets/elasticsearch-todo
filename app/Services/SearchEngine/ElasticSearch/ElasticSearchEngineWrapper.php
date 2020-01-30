<?php

namespace App\Services\SearchEngine\ElasticSearch;

use App\Services\SearchEngine\SearchEngineWrapperInterface;
use Elasticsearch\Client;

class ElasticSearchEngineWrapper implements SearchEngineWrapperInterface
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(array $parameters): array
    {
        return $this->client->index($parameters);
    }

    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }

    public function search(array $parameters): array
    {
        return $this->client->search($parameters);
    }

    public function find(array $parameters)
    {
        return $this->client->get($parameters);
    }

    public function init(array $parameters): array
    {
        return $this->client->indices()->create($parameters);
    }

    public function scroll(array $parameters)
    {
        return $this->client->scroll($parameters);
    }

    public function deleteIndex(array $parameters): array
    {
        return $this->client->indices()->delete($parameters);
    }
}
