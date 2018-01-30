<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_skins', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('user_id')->unique();
	        $table->string('condition');
	        $table->dateTime('check_time');
	        $table->string('makeup_habits');
	        $table->string('nursing_advice');
	        $table->string('characteristics');
	        $table->string('commonly_products');
	        $table->unsignedTinyInteger('skin_belong_id');
	        $table->unsignedTinyInteger('skin_category_id');
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
        Schema::dropIfExists('user_skins');
    }
}
