<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->text('tags')->nullable();
            $table->text('url');
            $table->text('thumbnail_url')->nullable();
            $table->integer('main_banner_width');
            $table->integer('main_banner_height');
            $table->integer('sub_banner_width');
            $table->integer('sub_banner_height');
            $table->integer('news_banner_width');
            $table->integer('news_banner_height');
            $table->integer('user_logo_width');
            $table->integer('user_logo_height');
            $table->integer('news_thumbnail_width');
            $table->integer('news_thumbnail_height');
            $table->string('status');
            $table->integer('user_id');
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
        Schema::dropIfExists('templates');
    }
}
