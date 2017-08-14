<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-8-11 下午2:03
 */

namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Picture;

class GetPicturesHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'group_id' => 'required|numeric'
        ], [
            'group_id.required' => '组图id为必传参数',
            'group_id.numeric' => '组图id必须为数字'
        ]);

        $id = $this->request->input('group_id');

        $pictures = Picture::query()->where('group_id', $id)->orderBy('orderBy', 'asc')->get();

        $this->withCode(200)->withData($pictures)->withMessage('获取数据成功');

    }
}