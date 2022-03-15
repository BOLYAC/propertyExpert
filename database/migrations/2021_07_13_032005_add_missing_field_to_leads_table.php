<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('excerpt')->nullable();
            $table->string('down_payment')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_discount')->nullable();
            $table->text('lead_description')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->text('lead_description')->nullable();
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
                'excerpt', 'down_payment', 'payment_type', 'payment_discount', 'lead_description'
            ]);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('lead_description');
        });
    }
}
