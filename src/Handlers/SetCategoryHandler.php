<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-24 下午5:08
 */

namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;
use Illuminate\Support\Facades\Storage;

/**
 * Class SetCategoryHandler.
 */
class SetCategoryHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function execute()
    {
        //新建一个分类
        $category = new Category();
        if (!$this->request->get('category_name')) {
            return $this->withCode(402)->withError('分类名称不能为空');
        }
        //如果分类Id没有填写，需要产生一个不重复的分类id别名。
        //如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。
        if ($alias = $this->request->get('category_id')) {
            if ($this->verify($alias)) {
                return $this->withCode('403')->withError('分类id在数据库中已存在,请重新定义');
            }
            $category->alias = $alias;
        } else {
            do {
                $random = mt_rand(0, 4999);
            } while ($this->verify($random));
            $category->alias = $random;
        }
        $category->name = $this->request->get('category_name');
        $category->user_id = 1;//默认上传用户Id为1,管理员用户
        $category->path = $category->alias;
        $createResult = Storage::makeDirectory($category->alias);
        $this->container->make('files')->move(base_path('/storage/app/' . $category->alias), base_path('/public/upload/' . $category->alias));
//        $createResult = Storage::move(app_path('/storage/app/' .$category->alias), base_path('/public/upload/'.$category->alias));
        if ($category->save() && $createResult) {
            return $this->withCode(200)->withMessage('分类信息保存成功');
        } else {
            return $this->withCode('401')->withError('保存分类信息失败，请稍后重试');
        }
    }

    /** 分类别名验重
     * @para   $alias
     *
     * @return bool
     */
    private function verify($alias)
    {
        $category = Category::where('alias', $alias)->first();
        if ($category) {
            return true;
        } else {
            return false;
        }
    }
}
