<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTasksNotesAgenciesDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_documents', function (Blueprint $table) {
            $table->morphs('source');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->morphs('source');
            $table->integer('agency_id')->after('user_id')->unsigned()->index()->nullable();
            $table->foreign('agency_id')->references('id')->on('agency');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('task_entry')->after('date')->nullable();
            $table->string('contact_type')->after('task_entry')->nullable();
            $table->string('contact_name')->after('contact_type')->nullable();
            $table->integer('agency_id')->after('user_id')->unsigned()->index()->nullable();
            $table->foreign('agency_id')->references('id')->on('agency');
            $table->morphs('source');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('company_type')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_documents', function (Blueprint $table) {
            $table->dropMorphs('source');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropMorphs('source');
            $table->dropColumn('agency_id');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropMorphs('source');
            $table->dropColumn('task_entry');
            $table->dropColumn('contact_type');
            $table->dropColumn('contact_name');
            $table->dropColumn('agency_id');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('company_type');
        });
    }
}
