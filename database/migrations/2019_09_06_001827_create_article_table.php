<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->string('slug', 150)->unique();
            $table->date('date')->default(date('Y-m-d'));
            $table->string('name', 150);
            $table->text('contents')->nullable();
            $table->text('teaser')->nullable();
            $table->string('status', 150)->default('draft');
            $table->string('is_featured', 150)->default('0');
            $table->text('image_url')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->string('meta_title', 150)->nullable();
            $table->string('meta_keyword', 150)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
