<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iLeyun.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Picture;

/**
 * Class ConfigurationHandler.
 */
class DeletePictureHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $path = $this->request->query('path');

        $picture = Picture::where('path', $path)->first();

        if ($picture)
        {
            $picture->delete();
        }

        if ($this->container->make('files')->exists(base_path($path)))
        {
            $this->container->make('files')->delete(base_path($path));
        }

        if (Picture::where('path', $path)->first() || $this->container->make('files')->exists(base_path($path)))
        {
            return $this->withCode('402')->withError('删除失败，请稍候再试');
        }

        return $this->success()->withMessage('删除成功');

    }
}
