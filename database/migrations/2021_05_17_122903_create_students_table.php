<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function (Blueprint $table) {
			$table->id();
			$table->string('student_id_no');
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name');
			$table->date('bdate');
			$table->integer('age');
			$table->string('email');
			$table->string('contact_number');
			$table->string('address');
			$table->string('province');
			$table->string('municipal');
			$table->string('barangay');
			$table->string('year_level');
			$table->string('semester');
			$table->string('course');
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
		Schema::dropIfExists('students');
	}
}