<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryCityToAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('representatives')->nullable();
            $table->text('representatives_phone')->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('vat_tax')->nullable();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'representatives', 'representatives_phone']);
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('vat_tax');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone', 'email']);
        });
    }
}
