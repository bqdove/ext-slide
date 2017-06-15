<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Group;

/**
 * Class GetHandler.
 */
class GetGroupHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $groupId = $this->request->get('group_id',null);

        if ($groupId){
            $group = Group::where('alias', $groupId)->first();

            $this->success()->withData([
                'group_id' => object_get($group, 'id'),
                'group_name' => object_get($group, 'name'),
                'show'  => object_get($group, 'show')
            ])->withMessage('获取图集数据成功！');
        }else{
            $groups = Group::all();

            $this->success()->withData($groups)->withMessage('获取图集数据成功！');
        }

    }
}
