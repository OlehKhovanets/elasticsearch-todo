<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        try {
            (new \App\Services\SearchEngine\Context(new \App\Services\SearchEngine\ElasticSearch\ElasticSearchMapping('posts', ['title', 'description'])))->deleteIndex();
            (new \App\Services\SearchEngine\Context(new \App\Services\SearchEngine\ElasticSearch\ElasticSearchMapping('posts', ['title', 'description'])))->mapping();
        } catch (Exception $exception) {
            (new \App\Services\SearchEngine\Context(new \App\Services\SearchEngine\ElasticSearch\ElasticSearchMapping('posts', ['title', 'description'])))->mapping();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new \App\Services\SearchEngine\Context(new \App\Services\SearchEngine\ElasticSearch\ElasticSearchMapping('posts', ['title', 'description'])))->deleteIndex();

        Schema::dropIfExists('posts');
    }
}
