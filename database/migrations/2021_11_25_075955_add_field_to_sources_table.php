<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->boolean('for_company')->default(0);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->boolean('title_deed')->default(0);
            $table->boolean('expertise_report')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropColumn('for_company');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['title_deed', 'expertise_report']);
        });
    }
}
