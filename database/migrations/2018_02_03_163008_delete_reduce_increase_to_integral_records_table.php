<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteReduceIncreaseToIntegralRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('integral_records', function (Blueprint $table) {
            $table->dropColumn('reduce');
            $table->dropColumn('increase');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('integral_records', function (Blueprint $table) {
	        $table->unsignedInteger('reduce')->nullable();
	        $table->unsignedInteger('increase')->nullable();
        });
    }
}
