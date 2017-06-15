<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Group;


class ShowGroupHandler extends AbstractSetHandler
{
    public function execute()
    {
        $groupId = $this->request->input('group_id');

        $group = Group::where('alias', $groupId)->get();

        if ($group->show)
        {
            $status = 0;
        }else{
            $status = 1;
        }

        $group->show = $status;

        $result = $group->save();

        if ($result)
        {
            $this->success()->withData([
                'show'  => object_get($group, 'show')
            ])->withMessage('获取显示状态数据成功！');
        }else{
            $this->withCode('401')->withMessage('获取现实状态失败');
        }
    }
}