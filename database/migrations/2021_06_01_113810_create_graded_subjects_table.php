<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradedSubjectsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graded_subjects', function (Blueprint $table) {
			$table->id();
			$table->foreignId('student_id')->constrained('students')->onDelete('cascade')->onUpdate('cascade');
			$table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade')->onUpdate('cascade');
			$table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('year_level');
			$table->string('semester');
			$table->integer('prelim');
			$table->integer('midterm');
			$table->integer('final');
			$table->integer('GPA');
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
		Schema::dropIfExists('graded_subjects');
	}
}