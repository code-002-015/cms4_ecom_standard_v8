<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('name');
            $table->text('slug');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('currency', 30)->default('PHP');
            $table->decimal('price',16,4)->nullable();
            $table->string('size', 30)->nullable();
            $table->string('weight')->nullable();
            $table->string('status',100);
            $table->string('uom',30)->default('PC');
            $table->string('brand')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('created_by');
            $table->string('meta_title', 150)->nullable();
            $table->string('meta_keyword', 150)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('code', 250)->nullable();
            $table->decimal('reorder_point',16,2)->default(0.00);
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
        Schema::dropIfExists('products');
    }
}
