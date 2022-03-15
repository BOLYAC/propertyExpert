<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentIdToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->integer('department_id')->after('team_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });

    }
}
