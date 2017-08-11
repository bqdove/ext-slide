<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-06-14 11:50:27
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
        if(!$this->schema->hasTable('slide_groups'))
            $this->schema->create('slide_groups', function (Blueprint $table) {
                $table->increments('id')->comment('组Id');//组Id
                $table->integer('user_id')->comment('创建图集的用户Id');//创建图集的用户Id
                $table->string('name', 64)->comment('组名');//组名
                $table->string('alias')->comment('组别名');//组别名
                $table->string('summery',64)->nullable()->comment('组简介');//分类简介
                $table->unsignedTinyInteger('show')->default(true)->comment('是否展示');//默认展示
                $table->unsignedInteger('category_id')->comment('分类的Id');
                $table->string('path')->comment('组图文件夹');
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
        $this->schema->drop('slide_groups');
    }
}
