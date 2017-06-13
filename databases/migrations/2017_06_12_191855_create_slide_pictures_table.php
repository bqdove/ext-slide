<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-06-12 19:18:55
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateSlidePicturesTable.
 */
class CreateSlidePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('slide_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('url',100);
            $table->string('backgroud', 10);
            $table->unsignedInteger('group_id');
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
        $this->schema->drop('slide_pictures');
    }
}
