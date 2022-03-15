<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToInvoicesAndAgencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('project_id')->unsigned()->index()->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->string('rep_1')->nullable();
            $table->string('rep_phone_1')->nullable();
            $table->string('rep_2')->nullable();
            $table->string('rep_phone_2')->nullable();
            $table->string('rep_3')->nullable();
            $table->string('rep_phone_3')->nullable();
            $table->text('projects')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('projects');
        });
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['rep_1', 'rep_phone_1', 'rep_2', 'rep_phone_2', 'rep_3', 'rep_phone_3', 'projects']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_1', 'phone_2']);
        });
    }
}
