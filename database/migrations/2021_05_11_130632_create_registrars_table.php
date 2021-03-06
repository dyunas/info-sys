<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrarsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registrars', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name');
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
		Schema::dropIfExists('registrars');
	}
}