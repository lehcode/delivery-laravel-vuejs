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
			$table->uuid('id');
			$table->primary('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->dateTime('last_login');
			$table->string('password');
			$table->string('photo')->nullable();
			$table->boolean('is_enabled')->default(1);
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("SET FOREIGN_KEY_CHECKS=0");
		Schema::dropIfExists('users');
		DB::statement("SET FOREIGN_KEY_CHECKS=1");
	}
}
