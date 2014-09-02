<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('projects', function(Blueprint $table)
        {
            $table->string('url')->after('description')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('projects', function(Blueprint $table)
        {
            $table->dropColumn('url');
        });
	}

}
