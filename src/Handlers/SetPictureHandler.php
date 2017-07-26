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
use Notadd\Slide\Models\Category;
use Notadd\Slide\Models\Picture;

/**
 * Class ConfigurationHandler.
 */
class SetPictureHandler extends AbstractSetHandler
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
            'link'  => 'required',
        ], [
            'title.required' => '图片标题为必填字段',
            'link.required'  => '图片跳转链接为必填字段',
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