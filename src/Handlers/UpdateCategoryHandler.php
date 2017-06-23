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
use Notadd\Slide\Models\Group;
use Illuminate\Support\Facades\Storage;

/**
 * Class ConfigurationHandler.
 */
class UpdateCategoryHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        //更新一个分类
        $this->validate($this->request, [
            'category_name' => 'required',
            'id' => 'required'
        ], [
            'category_name.required' => '分类名为必填字段',
            'id' => '分类id不能为空'
        ]);

        $category = Category::query()->find($this->request->input('id'));

//        if ($category instanceof Category && $category->update($this->request->only([
//                'category_name', 'alias'
//            ]))) {
//            $this->success()->withMessage('分类信息更新成功');
//        } else {
//            $this->withCode(402)->withError('更新失败');
//        }

        $category = Category::where('alias', $this->request->input('id'))->first();

        if ($alias = $this->request->input('category_id'))
        {
            if($this->verify($alias)){
                return $this->withCode('403')->withError('分类id在数据库中已存在,请重新定义');
            }

            $category->alias = $alias;
        }else{
            do{
                $random = mt_rand(0, 4999);
            }while($this->verify($random));

            $category->alias = $random;
        }

        $updateResult = $category->save();

        if ($updateResult)
        {
            return $this->success()->withMessage('更新分类信息成功');
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
