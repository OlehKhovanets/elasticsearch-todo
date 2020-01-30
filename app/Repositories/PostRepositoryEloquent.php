<?php

namespace App\Repositories;

use App\Contracts\Repositories\PostRepository;
use App\Models\Post;
use App\Repositories\BaseRepository;

/**
 * Class CompanyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    public function __construct()
    {
        $this->model = new Post;
    }
}
