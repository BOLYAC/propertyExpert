<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectsFieldsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained();
            $table->string('project_name')->nullable();
            $table->string('country_province')->nullable();
            $table->string('section_plot')->nullable();
            $table->string('block_num')->nullable();
            $table->string('room_number')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('gross_square')->nullable();
            $table->string('flat_num')->nullable();
            $table->string('reservation_amount')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('file_path')->nullable();
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
                'project_name',
                'country_province',
                'section_plot',
                'block_num',
                'room_number',
                'floor_number',
                'gross_square',
                'flat_num',
                'reservation_amount',
                'sale_price',
                'file_path'
            ]);
        });
    }
}
