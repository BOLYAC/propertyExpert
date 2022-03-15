<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('address')->nullable();
            $table->string('text_office')->nullable();
            $table->string('text_address')->nullable();
            $table->string('commission_rate')->nullable();
            $table->string('project_name')->nullable();
            $table->boolean('status')->default('1');
            $table->string('type')->nullable();
            $table->string('link')->nullable();
            $table->text('location')->nullable();
            $table->text('max_price')->nullable();
            $table->text('min_price')->nullable();
            $table->text('size')->nullable();
            $table->text('map')->nullable();
            $table->text('drive')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
