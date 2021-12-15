<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsActivityLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_by')->nullable();
            $table->string('activity_type')->nullable();
            $table->string('dashboard_activity')->nullable();
            $table->text('activity_desc')->nullable();
            $table->datetime('activity_date')->nullable();
            $table->string('db_table')->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->text('reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_activity_logs');
    }
}
