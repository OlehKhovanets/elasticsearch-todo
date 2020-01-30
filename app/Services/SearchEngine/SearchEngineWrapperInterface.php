<?php

namespace App\Services\SearchEngine;

interface SearchEngineWrapperInterface
{
    public function index(array $parameters);

    public function delete(array $parameters);

    public function search(array $parameters);

    public function find(array $parameters);

    public function init(array $parameters);

    public function scroll(array $parameters);

    public function deleteIndex(array $parameters);
}
