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

/**
 * Class GetPictureHandler.
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
        $this->validate($this->request, [
            'path' => 'required',
        ], [
            'path.required' => '图片路径为必填字段',
        ]);
        $picturePath = $this->request->input('path');
        $picture = Picture::query()->where('path', $picturePath)->first();
        if ($picture instanceof Picture) {
            $picture = $picture->toArray();

            return $this->withCode(200)->withData($picture)->withMessage('获取图片详情数据成功！');
        } else {
            return $this->withCode('402')->withError('获取图片详情失败，请稍后重试');
        }
    }
}