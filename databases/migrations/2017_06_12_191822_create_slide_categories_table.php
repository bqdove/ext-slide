<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-06-12 19:18:22
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateSlideCategoriesTable.
 */
class CreateSlideCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('slide_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
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
        $this->schema->drop('slide_categories');
    }
}
