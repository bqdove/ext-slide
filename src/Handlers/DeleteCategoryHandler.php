<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iLeyun.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Support\Facades\Storage;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;


/**
 * Class ConfigurationHandler.
 */
class DeleteCategoryHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $cateId = $this->request->get('category_id');

        $category = Category::where('alias', $cateId)->first();

        if (!$category)
        {
            return $this->withCode('404')->withError('请重新确认分类Id是否正确');
        }

        $groups = $category->groups()->with('pictures')->get();

        //如果此分类下图集为空，那么直接删除分类
        if (!$groups)
        {
            $result = $category->delete(
);
            if ($result)
            {
                return $this->success()->withMessage('删除分类成功');
            }
        }

        foreach($groups as $group)
        {
            $pictures = $group->pictures()->get();

            //如果该图集下图片数为零，那么删除该图集
            if (!count($pictures))
            {
                $group->delete();
            }

            //如果图集不为空，那么循环删除该图集的所有图片
            foreach($pictures as $picture)
            {
                $picture->delete();
            }
            //图集图片循环删除完毕后尝试删除当前图集信息

            $group->delete();

        }
        $catePath = $category->path;//注意获取顺序。必须在删除分类信息前获取此字段，否则无法获得。

        //如果当前分类的搜有图集及其所含图片删除完毕后，尝试删除当前想要删除的分类

        $result = $category->delete();

        $deleteResult = Storage::deleteDirectory($catePath);

        if ($result && $deleteResult)
        {
            return $this->success()->withMessage('删除分类成功');
        }
    }
}
