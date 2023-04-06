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
        Schema::table('vcrun_supporters', function (Blueprint $table) {
            $table->foreign(['supported_registrant_id'])->references(['id'])->on('vcrun_registrations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vcrun_supporters', function (Blueprint $table) {
            $table->dropForeign('vcrun_supporters_supported_registrant_id_foreign');
        });
    }
};
