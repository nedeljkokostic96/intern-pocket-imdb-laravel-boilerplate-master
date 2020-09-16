<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLikesTableAddMovieIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function(Blueprint $table){
            $table->integer('movie_id')->unsigned()->nullable();

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['movie_id']);
        $table->dropColumn('movie_id');
    }
}
