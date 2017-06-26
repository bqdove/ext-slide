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
        $this->validate($this->request, [
            'group_id' => 'required'
        ],[
            'group_id.required' => '图集id为必传参数'
        ]);

        $group = Group::where('alias', $this->request->input('group_id'))->first();
        
        if (!$group)
        {
            return $this->withCode(404)->withError('此图集不存在，请重试');
        }

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
            $this->withCode(200)->withData([
                'show'  => object_get($group, 'show')
            ])->withMessage('获取显示状态数据成功！');
        }else{
            $this->withCode('401')->withMessage('获取现实状态失败');
        }
    }
}