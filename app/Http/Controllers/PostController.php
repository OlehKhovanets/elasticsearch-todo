<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\PostRepository;
use App\Http\Requests\SearchPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostSearchResource;
use App\Models\Post;
use App\Services\SearchEngine\SearchEngineSearchInterface;

class PostController extends Controller
{
    protected PostRepository $postRepository;
    protected SearchEngineSearchInterface $searchEngineSearch;

    public function __construct(PostRepository $postRepository, SearchEngineSearchInterface $searchEngineSearch)
    {
        $this->postRepository = $postRepository;
        $this->searchEngineSearch = $searchEngineSearch;
    }

    public function store(StorePostRequest $request)
    {
        return new PostResource($this->postRepository->create($request->all()));
    }

    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->postRepository->update($post->id, $request->all());
    }

    public function destroy(Post $post)
    {
        $this->postRepository->delete($post->id);
    }

    public function search(SearchPostRequest $request)
    {
        $size = $request->get('size') ?? 10;
        $from = $request->get('from') ?? 0;

        $result = $this->searchEngineSearch
            ->init($size, $from, $request->get('query'))
            ->buildQuery()
            ->search()
            ->getResponse();

        return PostSearchResource::collection($result['result'])
            ->additional([
                'total' => $result['total'],
                'page' => $from
            ]);
    }
}
