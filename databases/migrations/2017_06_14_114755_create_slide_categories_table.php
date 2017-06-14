<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-06-14 11:47:55
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
        if(!$this->schema->hasTable('slide_categories'))
            $this->schema->create('slide_categories', function (Blueprint $table) {
                $table->increments('id')->comment('分类ID');//分类Id
                $table->integer('user_id')->comment('创建分类的用户Id');//创建分类的用户Id
                $table->string('name', 64)->comment('分类名字');//分类名字
                $table->string('alias')->comment('分类别名');//分类别名
                $table->string('summery',64)->nullable()->comment('分类简介');//分类简介
                $table->softDeletes();
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
