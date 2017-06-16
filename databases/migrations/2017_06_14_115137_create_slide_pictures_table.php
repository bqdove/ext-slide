<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-06-14 11:51:37
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
        if(!$this->schema->hasTable('slide_pictures'))
            $this->schema->create('slide_pictures', function (Blueprint $table) {
                $table->increments('id')->comment('图片ID');//图片ID
                $table->integer('user_id')->comment('图片上传用户id');//图片上传用户id
                $table->string('name')->comment('图片名称');//图片路径
                $table->string('path')->comment('图片路径，图片名MD5');//图片加密路径
                $table->string('title',64)->nullable()->comment('图片标题');
                $table->string('background', 10)->comment('填充颜色');
                $table->unsignedInteger('group_id')->comment('图片所属组Id');
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
        $this->schema->drop('slide_pictures');
    }
}
