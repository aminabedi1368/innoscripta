<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('author');
            $table->string('title');
            $table->text('description');
            $table->string('url');
            $table->string('urlToImage')->nullable();
            $table->string('published_at');
            $table->text('content');
            $table->string('category')->nullable();
            $table->foreignId('userId')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_articles');
    }
};
