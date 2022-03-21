<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_sse_country')->default(0);
            $table->boolean('can_sse_language')->default(0);
            $table->boolean('can_sse_source')->default(0);
            $table->boolean('can_sse_phone')->default(0);
            $table->boolean('can_sse_email')->default(0);
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
                'can_sse_country', 'can_sse_language', 'can_sse_source', 'can_sse_phone', 'can_sse_email'
            ]);
        });
    }
}
