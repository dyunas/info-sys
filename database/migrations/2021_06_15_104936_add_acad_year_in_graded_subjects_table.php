<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcadYearInGradedSubjectsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('graded_subjects', function (Blueprint $table) {
			$table->string('acad_year')->after('year_level');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('graded_subjects', function (Blueprint $table) {
			$table->dropColumn('acad_year');
		});
	}
}