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
    public function execute()
    {
        $groupId = $this->request->query('group_id');

        $path = $this->request->query('path');

        $name = $this->request->query('name');

        $title = $this->request->get('picture_title');

        $link = $this->request->get('link');

        $background = $this->request->get('background');

        if (!$background)
        {
            $background = '';
        }

        if (!$this->container->make('files')->exists(base_path($path)))
        {
            return $this->withCode('402')->withMessage('该图片已经不存在，请重新上传');
        }

        if ($picture = Picture::where('path', $path)->first())
        {
            $picture->path = $path;

            $picture->name = $name;

            $picture->title = $title;

            $picture->user_id = 1;

            $picture->background = $background;

            $picture->group_id = $groupId;

            if($picture->save())
            {
                return $this->success()->withMessage('更新图片信息成功');
            }
        }

        if (!$title || !$link)
        {
            return $this->withCode('401')->withMessage('图片，跳转链接为必填选项');
        }

        $picture = new Picture();

        $picture->path = $path;

        $picture->name = $name;

        $picture->title = $title;

        $picture->user_id = 1;

        $picture->background = $background;

        $picture->group_id = $groupId;

        if($picture->save())
        {
            return $this->success()->withMessage('新建图片信息成功');
        }

    }
}