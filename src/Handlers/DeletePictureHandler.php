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
 * Class DeletePictureHandler.
 */
class DeletePictureHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {

        $this->validate($this->request, [
            'path' => 'required',
        ], [
            'path.required' => '图片路径为必传参数',
        ]);
        $path = $this->request->input('path');

        $subPath = strstr($path, '/upload');

        $completePath = base_path('/public'. $subPath);

        $picture = Picture::query()->where('path', $path)->first();

        if (Picture::query()->where('path', $path)->first() || $this->container->make('files')->exists($completePath)) {
            $this->withCode('500')->withError('删除失败，请稍候再试');
        }

        if ($picture instanceof Picture) {
            $picture->delete();
        }

        if ($this->container->make('files')->exists($completePath)) {
            $this->container->make('files')->delete($completePath);
        }


        $this->withCode(200)->withMessage('删除成功');
    }
}
