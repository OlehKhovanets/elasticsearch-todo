<?php

namespace App\Providers;

use App\Contracts\Repositories\PostRepository;
use App\Models\Post;
use App\Observers\PostObserver;
use App\Repositories\PostRepositoryEloquent;
use App\Services\SearchEngine\ElasticSearch\ElasticSearchEngineWrapper;
use App\Services\SearchEngine\ElasticSearch\ElasticSearchSearch;
use App\Services\SearchEngine\SearchEngineSearchInterface;
use App\Services\SearchEngine\SearchEngineWrapperInterface;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SearchEngineWrapperInterface::class, ElasticSearchEngineWrapper::class);
        $this->app->bind(SearchEngineSearchInterface::class, ElasticSearchSearch::class);

        $this->app->bind(ElasticSearchEngineWrapper::class, function ($app) {
            return new ElasticSearchEngineWrapper(
                ClientBuilder::create()
                    ->setHosts(['elastic'])
                    ->build()
            );
        });

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(PostRepository::class, PostRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
    }
}
