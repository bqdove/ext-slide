<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-24 下午5:08
 */

namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Group;

/**
 * Class GetGroupHandler.
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

        $group = Group::query()->where('alias', $this->request->input('group_id'))->first();

        if ($group instanceof Group) {
            $this->withCode(200)->withData([
                'group_id' => object_get($group, 'id'),
                'group_name' => object_get($group, 'name'),
                'show' => object_get($group, 'show'),
            ])->withMessage('获取图集数据成功！');
        } else if (is_null($group)) {
            $this->withCode(402)->withError('图集不存在');
        } else {
            $this->withCode('404')->withError('获取图集失败');
        }
    }
}
