<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLockedColInGradedSubjectsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('graded_subjects', function (Blueprint $table) {
			$table->boolean('is_locked')->default(0)->after('GPA');
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
			$table->dropColumn('is_locked');
		});
	}
}