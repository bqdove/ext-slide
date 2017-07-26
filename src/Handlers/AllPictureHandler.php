<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Picture;

/**
 * Class GetHandler.
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
            'group_ip.required' => '图集id为必填字段',
        ]);
        $pictures = Picture::where('group_id', $this->request->input('group_id'))->get()->toArray();
        if (count($pictures) > 0) {
            $this->withCode(200)->withData($pictures)->withMessage('获取数据成功！');
        } else {
            $this->withCode(402)->withError('此图集为空');
        }
    }
}