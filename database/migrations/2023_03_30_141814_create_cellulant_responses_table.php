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
        Schema::create('cellulant_responses', function (Blueprint $table) {
            $table->bigInteger('cellulantResponseID', true);
            $table->string('checkOutRequestID', 50);
            $table->string('merchantTransactionID', 50);
            $table->string('requestStatusCode', 4);
            $table->text('requestStatusDescription');
            $table->string('MSISDN', 16);
            $table->string('serviceCode', 64);
            $table->string('accountNumber', 64);
            $table->string('currencyCode', 3);
            $table->double('amountPaid')->default(0);
            $table->string('requestCurrencyCode', 3);
            $table->double('requestAmount')->default(0);
            $table->string('requestDate', 50);
            $table->text('payments');
            $table->dateTime('creation_date');
            $table->dateTime('last_update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cellulant_responses');
    }
};
