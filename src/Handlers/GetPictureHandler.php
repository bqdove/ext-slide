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
class GetPictureHandler extends Handler
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

            $pictures = $group->pictures()->get();

            return $this->success()->withData($pictures)->withMessage('获取图集详情数据成功！');
        }else{
            return $this->withCode('402')->withError('获取图片详情失败，请稍后重试');
        }

    }
}