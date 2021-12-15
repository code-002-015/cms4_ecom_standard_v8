<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_page_id')->nullable();
            $table->integer('album_id')->nullable();
            $table->string('slug')->unique();
            $table->string('name', 150);
            $table->string('label', 150)->nullable();
            $table->text('contents')->nullable();
            $table->string('status', 150)->default('draft');
            $table->string('page_type', 150)->default('custom');
            $table->text('image_url')->nullable();
            $table->string('meta_title', 150)->nullable();
            $table->string('meta_keyword', 150)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('user_id')->nullable();
            $table->string('template')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
