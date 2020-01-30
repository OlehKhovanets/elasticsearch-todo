<?php

namespace App\Services\SearchEngine;

class Context
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function mapping()
    {
        $this->strategy->mapping();
    }

    public function deleteIndex()
    {
        $this->strategy->deleteIndex();
    }
}
