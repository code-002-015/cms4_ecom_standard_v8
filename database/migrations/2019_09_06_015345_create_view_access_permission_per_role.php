<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewAccessPermissionPerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_access_permission_per_role AS SELECT user_id, role, GROUP_CONCAT(name SEPARATOR '|') AS permissions
                            FROM view_role_permission
                                GROUP BY user_id, role");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_access_permission_per_role");
    }
}
