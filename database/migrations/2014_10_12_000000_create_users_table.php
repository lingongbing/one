<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('mobile')->unique();
	        $table->string('username')->unique();
	        $table->string('password');
	        $table->boolean('is_agent')->default(FALSE);
	        $table->unsignedInteger('parent_id')->default(0)->index();

	        $table->string('name')->nullable();
	        $table->string('level')->nullable();
	        $table->string('region')->nullable();
	        $table->string('avatar')->nullable();
	        $table->string('wechat')->nullable();
	        $table->string('address')->nullable();
	        $table->string('introduction')->nullable();
	        $table->unsignedInteger('integral')->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
