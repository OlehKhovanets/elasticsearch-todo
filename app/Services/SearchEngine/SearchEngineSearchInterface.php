<?php

namespace App\Services\SearchEngine;

interface SearchEngineSearchInterface
{
    public function init(int $size, int $form, string $query);

    public function buildQuery();

    public function search();

    public function getResponse();
}
