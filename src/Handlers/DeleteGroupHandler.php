<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iLeyun.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;
use Notadd\Slide\Models\Group;
/**
 * Class ConfigurationHandler.
 */
class DeleteGroupHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $groupId = $this->request->input('group_id');

        $group = Group::where('alias', $groupId)->first();

        if (!$group)
        {
            return $this->withCode('404')->withMessage('请重新确认图集Id是否正确');
        }

        $pictures = $group->pictures()->get();

        //如果此分类下图集为空，那么直接删除分类
        if (!$pictures)
        {
            $result = $group->delete();
            if ($result)
            {
                return $this->success()->withMessage('删除图集成功');
            }
        }


        //如果图集不为空，那么循环删除该图集的所有图片
        foreach($pictures as $picture)
        {
            $picture->delete();
        }
        //图集图片循环删除完毕后尝试删除当前图集信息

        $result = $group->delete();

        if ($result)
        {
            $this->success()->withMessage('删除图集成功');
        }
    }
}
