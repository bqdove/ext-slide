<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-28 下午5:24
 */

namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Picture;

class UpdatePictureHandler extends Handler
{
    public function execute()
    {
        $this->validate($this->request, [
            'path' => 'required',

        ], [
            'path.required' => '图片路径为必传参数',
        ]);

        $path = $this->request->input('path');
    }
}