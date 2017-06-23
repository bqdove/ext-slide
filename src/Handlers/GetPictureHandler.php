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
use Notadd\Slide\Models\Picture;

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
        $this->validate($this->request, [
            'path' => 'required'
        ],[
            'path.required' => '图片路径为必填字段'
        ]);

        $picturePath = $this->request->input('path');

        $picture = Picture::where('path', $picturePath)->first();

        if ($picture instanceof Picture)
        {
            $picture = Picture::where('path', $picturePath)->first()->toArray();
            return $this->success()->withData($picture)->withMessage('获取图片详情数据成功！');
        }else{
            return $this->withCode('402')->withError('获取图片详情失败，请稍后重试');
        }
    }
}