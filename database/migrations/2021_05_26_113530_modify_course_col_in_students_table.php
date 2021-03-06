<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCourseColInStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students', function (Blueprint $table) {
			$table->dropColumn('course');
			$table->foreignId('course_id')->after('semester')->constrained('courses')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('students', function (Blueprint $table) {
			$table->dropColumn('course_id');
			$table->string('course');
		});
	}
}