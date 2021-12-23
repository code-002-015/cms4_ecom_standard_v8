<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('product_id')->nullable();
            $table->integer('coupon_id');
            $table->string('coupon_code');
            $table->integer('sales_header_id');
            $table->string('order_status')->default('UNPAID');
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
        Schema::dropIfExists('coupon_sales');
    }
}
