<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('task_description')->default(0);
            $table->tinyInteger('alotech_calls')->default(0);
            $table->tinyInteger('edit_lead')->default(0);
            $table->tinyInteger('edit_name')->default(0);
            $table->tinyInteger('edit_phone')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'task_description', 'alotech_calls', 'edit_lead', 'edit_name', 'edit_phone'
            ]);
        });
    }
}
