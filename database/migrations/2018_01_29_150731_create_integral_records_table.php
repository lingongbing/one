<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegralRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_records', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('action');
	        $table->unsignedInteger('user_id')->index();
	        $table->unsignedInteger('reduce')->nullable();
	        $table->unsignedInteger('order_id')->nullable();
	        $table->unsignedInteger('increase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integral_records');
    }
}
