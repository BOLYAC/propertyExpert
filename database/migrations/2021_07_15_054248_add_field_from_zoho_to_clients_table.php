<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFromZohoToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('lead_source')->nullable();
            $table->string('lead_status')->nullable();
            $table->string('last_activity_time')->nullable();
            $table->string('social_media_source')->nullable();
            $table->string('ad_network')->nullable();
            $table->string('search_partner_network')->nullable();
            $table->string('ad_campaign_name')->nullable();
            $table->string('adgroup_name')->nullable();
            $table->string('ad')->nullable();
            $table->string('ad_click_date')->nullable();
            $table->string('adset_name')->nullable();
            $table->string('form_name')->nullable();
            $table->string('ad_name')->nullable();
            $table->string('reason_lost')->nullable();
            $table->tinyInteger('imported_from_zoho')->nullable();
            $table->string('zoho_id')->nullable();
            $table->string('customer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'lead_source', 'lead_status', 'last_activity_time', 'social_media_source',
                'ad_network', 'search_partner_network', 'ad_campaign_name', 'adgroup_name',
                'ad_click_date', 'ad', 'adset_name', 'form_name', 'ad_name', 'reason_lost',
                'imported_from_zoho', 'zoho_id', 'customer_id'
            ]);
        });
    }
}
