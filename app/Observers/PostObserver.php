<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\SearchEngine\SearchEngineWrapperInterface;

class PostObserver
{
    protected $elastic;

    public function __construct()
    {
        $elastic = app(SearchEngineWrapperInterface::class);
        $this->elastic = $elastic;
    }
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        $this->elastic->index([
            'index' => 'posts',
            'id' => $post->id,
            'body' => $post->toArray()
        ]);
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        $this->elastic->index([
            'index' => 'posts',
            'id' => $post->id,
            'body' => $post->toArray()
        ]);
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        $this->elastic->delete([
            'index' => 'posts',
            'id' => $post->id,
        ]);
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
