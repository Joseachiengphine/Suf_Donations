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
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->string('merchantID', 50)->primary();
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('country', 50);
            $table->string('city', 50);
            $table->string('email', 50);
            $table->string('zipCode', 50);
            $table->string('currency', 3);
            $table->string('company', 70)->nullable();
            $table->char('salutation', 6);
            $table->string('phoneNumber', 15);
            $table->text('requestDescription');
            $table->dateTime('creation_date');
            $table->dateTime('last_update');
            $table->string('job_title', 150)->nullable();
            $table->string('graduation_class', 60)->nullable();
            $table->string('campaign')->nullable();
            $table->string('relation')->nullable();
            $table->string('student_number', 191)->nullable();
            $table->string('shirt_size', 191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donation_requests');
    }
};
