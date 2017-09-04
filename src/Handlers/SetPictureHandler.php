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
 * Class SetPictureHandler.
 */
class SetPictureHandler extends Handler
{
    /**
     * @return $this
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'path' => 'required',
        ], [
            'path.required' => '图片路径为必传字段',
        ]);
        $path = $this->request->input('path');

        $link = $this->request->input('link');

        $title = $this->request->input('title');

        $background = $this->request->input('background');

        $subPath = strstr($path, '/upload');

        $completePath = base_path('/public'. $subPath);

        if (!$this->container->make('files')->exists($completePath)) {
            return $this->withCode('402')->withError('该图片已经不存在，请重新上传');
        }
        if ($picture = Picture::where('path', $path)->first()) {
            $picture->link = $link;
            $picture->title = $title;
            $picture->background = $background;
            $result = $picture->save();
            if ($result) {
                return $this->withCode(200)->withMessage('设置图片信息成功');
            } else {
                return $this->withCode(500)->withError('设置图片信息失败');
            }
        }
    }
}