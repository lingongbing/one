<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsigneegPhoneToOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('integral_orders', function (Blueprint $table) {
			$table->dropColumn('state');
			$table->unsignedBigInteger('courier_order_no')->nullable()->change();
			$table->string('courier_order_no')->change();
			$table->string('consignee');
			$table->string('phone');
			$table->string('address');
			$table->string('province');
			$table->string('city');
			$table->string('area');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('integral_orders', function (Blueprint $table) {
			$table->dropColumn('consignee');
			$table->dropColumn('phone');
			$table->dropColumn('address');
			$table->dropColumn('province');
			$table->dropColumn('city');
			$table->dropColumn('area');
		});
	}
}
