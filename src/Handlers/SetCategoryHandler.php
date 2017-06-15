<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Controllers\CategoryController;
use Notadd\Slide\Models\Category;

/**
 * Class ConfigurationHandler.
 */
class SetCategoryHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        if (!$this->request->input('cate_name'))
        {
            $this->withCode('402')->withMessage('分类名称不能为空');
        }
//        如果分类Id没有填写，需要产生一个不重复的分类id别名。
//        如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。
        if (!$this->request->input('cate_id'))
        {

        }else{

        }
        $category = new Category();

        $category->name = $this->request->input('cate_name');


//        $category = Category::where('alias', $cateId)->first();
//
//        $category->name = $this->request->input('cate_name');
//
//        $category->alias = $this->request->input('cate_id');
//
//        $this->success()->withMessage('更新分类'.object_get($category, 'name').'数据成功！');

        return true;
    }
}
