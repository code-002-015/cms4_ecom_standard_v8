<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryReceiverHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_receiver_header', function (Blueprint $table) {
            $table->id();
            $table->datetime('posted_at')->nullable();
            $table->integer('posted_by')->nullable();
            $table->integer('user_id');
            $table->string('status')->default('SAVED');  
            $table->datetime('cancelled_at')->nullable();
            $table->integer('cancelled_by')->nullable();                      
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
        Schema::dropIfExists('inventory_receiver_header');
    }
}
