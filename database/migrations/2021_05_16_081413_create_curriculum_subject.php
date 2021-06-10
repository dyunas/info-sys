<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumSubject extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('curriculum_subject', function (Blueprint $table) {
			$table->id();
			$table->foreignId('curriculum_id')->constrained('curriculums')->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('subject_id')->constrained('subjects')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('year_level');
			$table->string('semester');
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
		Schema::dropIfExists('curriculum_subject');
	}
}