<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeadFielsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->text('country')->nullable();
            $table->text('nationality')->nullable();
            $table->text('language')->nullable();
            $table->string('priority')->nullable();
            $table->string('status_name')->nullable();
            $table->integer('status_id')->nullable();
            $table->string('source_name')->nullable();
            $table->integer('source_id')->nullable();
            $table->string('agency_name')->nullable();
            $table->integer('agency_id')->nullable();
            $table->text('budget_request')->nullable();
            $table->text('rooms_request')->nullable();
            $table->text('requirement_request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'country', 'nationality', 'language', 'priority', 'status_name',
                'status_id', 'source_name', 'source_id', 'agency_name', 'agency_id',
                'budget_request', 'rooms_request', 'requirement_request'
            ]);
        });
    }
}
