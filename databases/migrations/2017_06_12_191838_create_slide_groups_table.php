<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-06-12 19:18:38
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateSlideGroupsTable.
 */
class CreateSlideGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('slide_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->string('name', 60);
            $table->unsignedTinyInteger('show');
            $table->unsignedInteger('category_id');
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
        $this->schema->drop('slide_groups');
    }
}
