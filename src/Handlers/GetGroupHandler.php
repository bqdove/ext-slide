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
        $this->validate($this->request, [
            'group_id' => 'required',
        ], [
            'group_id.required' => '图集ID为必传参数',
        ]);

        $group = Group::where('alias', $this->request->query('group_id'))->first();

        if ($group instanceof Group)
        {
            $this->success()->withData([
                'group_id' => object_get($group, 'id'),
                'group_name' => object_get($group, 'name'),
                'show'  => object_get($group, 'show')
            ])->withMessage('获取图集数据成功！');
        }elseif(is_null($group)){
            $this->withCode(402)->withError('图集不存在');
        }else{
            $this->withCode('404')->withError('获取图集失败');
        }

    }
}
