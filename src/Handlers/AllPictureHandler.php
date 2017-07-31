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
use Notadd\Slide\Models\Picture;
use Notadd\Slide\Models\Group;

/**
 * Class ALlPictureHandler.
 */
class ALlPictureHandler extends Handler
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
            'group_id.required' => '图集id为必填字段',
        ]);

        $group = Group::query()->where('alias', $this->request->input('group_id'))->first();

        $pictures = Picture::query()->where('group_id', $group->id)->orderBy('created_at', 'asc')->limit(4)->get();

        if (count($pictures) > 0) {
            $this->withCode(200)->withData($pictures)->withMessage('获取数据成功！');
        } else {
            $this->withCode(204)->withData([])->withMessage('此图集为空');
        }
    }
}