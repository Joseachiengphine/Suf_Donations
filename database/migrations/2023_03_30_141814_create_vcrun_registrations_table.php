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
        Schema::create('vcrun_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_merchant_id', 50)->comment('references merchantID on donation_requests');
            $table->enum('participation_type', ['PHYSICAL', 'VIRTUAL']);
            $table->double('race_kms');
            $table->double('registration_amount')->nullable()->default(1000);
            $table->enum('status', ['PENDING', 'PAID', 'CANCELLED']);
            $table->unsignedBigInteger('matching_donor_id')->nullable()->index('vcrun_registrations_matching_donor_id_foreign');
            $table->double('matched_amount')->nullable();
            $table->timestamps();
            $table->double('paid_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vcrun_registrations');
    }
};
