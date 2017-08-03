<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelGoogleKeywordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{    
        Schema::create('lgk_keywords', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('url', 80)->index();
            $table->string('keyword', 80);
            $table->date('date');
            $table->tinyInteger('clicks');
            $table->tinyInteger('impressions');
            $table->float('ctr');
            $table->float('avg_position');
            $table->timestamps();

            $table->unique(['url', 'keyword', 'date']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('lgk_keywords');
	}

}
