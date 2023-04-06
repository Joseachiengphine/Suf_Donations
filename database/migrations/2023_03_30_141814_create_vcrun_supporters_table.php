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
        Schema::create('vcrun_supporters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supported_registrant_id')->nullable()->index('vcrun_supporters_supported_registrant_id_foreign');
            $table->string('request_merchant_id', 50)->comment('references the donation_requests table');
            $table->double('support_amount');
            $table->enum('status', ['PENDING', 'PAID', 'CANCELLED']);
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
        Schema::dropIfExists('vcrun_supporters');
    }
};
