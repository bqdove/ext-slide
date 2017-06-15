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
use Notadd\Slide\Models\Group;
use Notadd\Slide\Models\Picture;

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
            return $this->withCode('404')->withMessage('请重新确认分类Id是否正确');
        }

        $groups = $category->groups()->with('pictures')->get();

        foreach($groups as $group)
        {
            $pictures = $group->pictures()->get();
            //循环删除某个图集的所有图片
            foreach($pictures as $picture)
            {
                try{
                    $picture->delete();
                }catch (\PDOException $PDOException){
                    Picture::rollback();
                    return false;
                }
            }
            //图集图片循环删除完毕后尝试删除当前图集信息
            try{
                $group->delete();
            }catch (\PDOException $PDOException){
                Group::rollback();
                return false;
            }
        }

        //如果当前分类的搜有图集及其所含图片删除完毕后，尝试删除当前想要删除的分类
        try{
            $category->delete();
            $this->success()->withMessage('删除分类成功');
        }catch (\PDOException $PDOException){
            Category::rollback();
            return false;
        }
    }
}
