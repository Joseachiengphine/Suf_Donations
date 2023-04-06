<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->string('donation_code', 50)->primary();
            $table->text('donation_description');
            $table->string('service_code', 64);
            $table->char('country_code', 2);
            $table->char('lang', 2);
            $table->text('success_redirect_url');
            $table->text('fail_redirect_url');
            $table->text('payment_web_hook');
            $table->integer('due_date_duration_in_hours')->default(1);
            $table->string('page_title', 50);
            $table->string('access_key', 64);
            $table->string('account_nbr', 64);
            $table->string('secret_key', 64);
            $table->string('init_vector', 64);
            $table->text('checkout_url');
            $table->string('default_campaign');
            $table->string('default_relation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
};
