<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('user_id')->index();
	        $table->bigInteger('order_no')->unique();
	        $table->unsignedInteger('goods_id')->index();
	        $table->string('courier_order_no')->unique();
	        $table->unsignedInteger('creator_user_id')->index();
	        $table->string('courier_company');
	        $table->unsignedInteger('goods_total_price');
	        $table->unsignedInteger('goods_number');
	        $table->string('customer_address')->nullable();
	        $table->unsignedTinyInteger('state')->default(1)->comment('1是正在交易,2是已经完成');
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
        Schema::dropIfExists('orders');
    }
}
