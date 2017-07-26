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
            'title' => 'required',
            'link' => 'required',
        ], [
            'title.required' => '图片标题为必填字段',
            'link.required' => '图片跳转链接为必填字段',
        ]);
        $link = $this->request->input('link');
        $title = $this->request->input('title');
        $path = $this->request->input('path');
        $background = $this->request->input('background');
        if (!$background) {
            $background = '';
        }
        if (!$this->container->make('files')->exists($path)) {
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