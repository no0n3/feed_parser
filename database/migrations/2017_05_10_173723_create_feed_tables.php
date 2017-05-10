<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_feed_source', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('rss_link', 255)->nullable();
            $table->timestamp('last_build_time')->nullable();
            $table->timestamps();
        });

        Schema::create('twitter_trend_feed_source', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('woid')->unique();
            $table->timestamp('last_build_time')->nullable();
            $table->timestamps();
        });

        Schema::create('rss_feed', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_id');
            $table->foreign('source_id')
                ->references('id')
                ->on('rss_feed_source');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('link', 255)->nullable();
            $table->timestamp('publish_time')->nullable();
            $table->timestamps();
        });

        Schema::create('twitter_feed', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_id');
            $table->foreign('source_id')
                ->references('id')
                ->on('twitter_trend_feed_source');
            $table->bigInteger('tweet_id')->unique();
            $table->bigInteger('author_id');
            $table->string('author_name', 255)->nullable();
            $table->text('text')->nullable();
            $table->timestamp('publish_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rss_feed_source');
        Schema::dropIfExists('twitter_trend_feed_source');
        Schema::dropIfExists('rss_feed');
        Schema::dropIfExists('twitter_feed');
    }
}
