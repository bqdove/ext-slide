<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;
use Illuminate\Support\Facades\Storage;

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
        //更新一个分类

        if ($_categoryId = $this->request->query('category_id'))
        {
            $_category = Group::where('alias', $_categoryId)->first();

            if (!$this->request->input('category_name'))
            {
                return $this->withCode('402')->withMessage('分类名称不能为空');
            }

            if ($_alias = $this->request->input('category_id'))
            {
                if($this->verify($_alias)){
                    return $this->withCode('403')->withMessage('分类id在数据库中已存在,请重新定义');
                }

                $_category->alias = $_alias;
            }else{
                do{
                    $random = mt_rand(0, 4999);
                }while($this->verify($random));

                $_category->alias = $random;
            }

            $updateResult = $_category->save();

            if ($updateResult)
            {
                return $this->success()->withMessage('更新分类信息成功');
            }
        }

        //新建一个分类
        $category = new Category();

        if (!$this->request->get('category_name'))
        {
            return $this->withCode('402')->withMessage('分类名称不能为空');
        }
        //如果分类Id没有填写，需要产生一个不重复的分类id别名。
        //如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。
        if ($alias = $this->request->get('category_id'))
        {
            if($this->verify($alias)){
                return $this->withCode('403')->withMessage('分类id在数据库中已存在,请重新定义');
            }

            $category->alias = $alias;
        }else{
            do{
                $random = mt_rand(0, 4999);
            }while($this->verify($random));

            $category->alias = $random;
        }

        $category->name = $this->request->get('category_name');

        $category->user_id = 1;//默认上传用户Id为1,管理员用户

        $category->path = $category->alias;

        $createResult = Storage::makeDirectory($category->alias);

        $createResult = Storage::move(app_path('/storage/app/' .$category->alias), app_path('/public/upload/'.$category->alias));

        if ($category->save() && $createResult){
            return $this->success()->withMessage('分类信息保存成功');
        }else{
            return $this->withCode('401')->withMessage('保存分类信息失败，请稍后重试');
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
