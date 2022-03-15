<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('unit_type')->nullable();
            $table->string('flat_type')->nullable();
            $table->string('floor')->nullable();
            $table->string('gross_sqm')->nullable();
            $table->string('net_sqm')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('created_by')->constrained();
            $table->foreignId('updated_by')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('project_id')->constrained();
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
        Schema::dropIfExists('properties');
    }
}
