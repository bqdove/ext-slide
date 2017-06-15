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
        $category = new Category();

        if (!$this->request->input('category_name'))
        {
            $this->withCode('402')->withMessage('分类名称不能为空');
        }
//        如果分类Id没有填写，需要产生一个不重复的分类id别名。
//        如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。
        if ($alias = $this->request->input('category_id'))
        {
            if($this->verify($alias)){
                $this->withCode('403')->withMessage('分类id在数据库中已存在,请重新定义');
            }

            $category->alias = $alias;
        }else{
            do{
                $random = mt_rand(0, 1999);
            }while($this->verify($random));

            $category->alias = $random;
        }

        $category->name = $this->request->input('category_name');

        $category->user_id = 1;//默认上传用户Id为1,管理员用户

        if ($category->save()){
            $this->success()->withMessage('分类信息保存成功');
        }else{
            $this->withCode('401')->withMessage('保存分类信息失败，请稍后重试');
        }
    }

    /** 分类别名验重
     * @para   $alias
     * @return bool
     */
    private function verify($alias)
    {
        $category = Category::where('alias', $alias)->first();
        if ($category)
        {
            return true;
        }else{
            return false;
        }
    }
}
