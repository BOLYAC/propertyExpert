<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_client', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('SET NULL');
            $table->foreignId('client_id')->constrained()->onDelete('SET NULL');
            $table->primary(['client_id', 'user_id']);
            $table->string('user_name')->nullable();
            $table->string('added_by')->nullable();
            $table->timestamps();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->json('sellers')->nullable();
            $table->json('sells_names')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->boolean('zoom_meeting')->default(0);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->string('companies_name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_client');

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['sellers', 'sells_names']);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('zoom_meeting');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('companies_name');
        });
    }
}
