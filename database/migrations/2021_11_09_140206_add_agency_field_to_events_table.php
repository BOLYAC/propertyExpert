<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgencyFieldToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('agency_type')->nullable();
            $table->text('agency_tax_number')->nullable();
            $table->text('agency_tax_branch')->nullable();
            $table->text('agency_phone')->nullable();
            $table->text('agency_email')->nullable();
            $table->text('customer_name')->nullable();
            $table->text('customer_passport_id')->nullable();
            $table->text('customer_phone_number')->nullable();
            $table->text('agency_country')->nullable();
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
            $table->dropColumn([
                'agency_type', 'agency_tax_number', 'agency_tax_branch', 'agency_phone',
                'agency_email', 'agency_country', 'customer_name', 'customer_passport_id', 'customer_phone_number'
            ]);
        });
    }
}
