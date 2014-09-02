<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('series_id')->nullable();

			$table->string('title');
			$table->string('slug');
			$table->text('content');
			$table->integer('views')->default(0);

			$table->timestamps();
			$table->timestamp('published_at')->nullable();
			$table->softDeletes();

			$table->index('user_id');
			$table->index('slug');

			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
