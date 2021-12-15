<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_role_permission AS SELECT role_permission.user_id, role_permission.role_id AS role, permission.name, permission.module AS permission_module
                            FROM role_permission 
                                INNER JOIN permission ON role_permission.permission_id = permission.id
                                WHERE role_permission.isAllowed = 1");
    }

    /**
     * Reverse the migrations.
     *ba
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW view_role_permission');
    }
}
