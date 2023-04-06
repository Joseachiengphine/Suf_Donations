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
        Schema::table('vcrun_registrations', function (Blueprint $table) {
            $table->foreign(['matching_donor_id'])->references(['id'])->on('matching_donors')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vcrun_registrations', function (Blueprint $table) {
            $table->dropForeign('vcrun_registrations_matching_donor_id_foreign');
        });
    }
};
