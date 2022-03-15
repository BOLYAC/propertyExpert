<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('commission_rate')->nullable();
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('tax_branch')->nullable();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->string('tax_branch')->nullable();
            $table->string('tax_number')->nullable();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('user_commission_rate')->nullable();
            $table->string('agency_commission_rate')->nullable();
            $table->string('project_commission_rate')->nullable();
        });

        Schema::create('stage_logs', function (Blueprint $table) {
            $table->id();
            $table->string('stage_name')->nullable();
            $table->string('update_by')->nullable();
            $table->string('user_name')->nullable();
            $table->string('stage_id')->nullable();
            $table->integer('lead_id')->unsigned()->index()->nullable();
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->softDeletes();
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
        Schema::dropIfExists('stage_log');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('commission_rate');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('tax_branch');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('tax_branch');
            $table->dropColumn('tax_number');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('user_commission_rate');
            $table->dropColumn('agency_commission_rate');
            $table->dropColumn('project_commission_rate');
        });
    }
}
