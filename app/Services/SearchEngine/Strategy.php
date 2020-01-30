<?php

namespace App\Services\SearchEngine;

interface Strategy
{
    public function mapping();

    public function deleteIndex();
}
