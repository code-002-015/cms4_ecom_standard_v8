<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusHasPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus_has_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->integer('parent_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->integer('page_order');
            $table->string('label', 150)->nullable();
            $table->text('uri')->nullable();
            $table->string('target', 150)->default('');
            $table->string('type');
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
        Schema::dropIfExists('menus_has_pages');
    }
}
