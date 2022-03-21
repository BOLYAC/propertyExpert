<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketings', function (Blueprint $table) {
            $table->id();
            $table->string('lead_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('country')->nullable();
            $table->string('created_date')->nullable();
            $table->string('ad_name')->nullable();
            $table->string('adset_name')->nullable();
            $table->string('campaign_name')->nullable();
            $table->string('form_name')->nullable();
            $table->string('platform')->nullable();
            $table->string('source')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('created_by')->constrained();
            $table->foreignId('updated_by')->constrained();
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
        Schema::dropIfExists('marketings');
    }
}
