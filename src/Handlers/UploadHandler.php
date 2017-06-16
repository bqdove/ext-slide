<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午6:05
 */

namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Foundation\Routing\Abstracts\Handler;

class UploadHandler extends Handler
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * UploadHandler constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Container $container, Filesystem $filesystem)
    {
        parent::__construct($container);
        $this->messages->push($this->translator->trans('上传图片成功！'));
        $this->files = $filesystem;
    }

    public function execute()
    {
        $this->validate($this->request, [
            'file' => 'required|image',
        ], [
            'file.image'    => '上传文件格式必须为图片格式！',
            'file.required' => '必须上传一个文件！',
        ]);
        $avatar = $this->request->file('file');

        $realName = $avatar->getClientOriginalName();

        $error = $avatar->getError();

        $hash = hash_file('md5', $avatar->getPathname(), false);
        $dictionary = $this->pathSplit($hash, '12', Collection::make([
            '../storage/uploads',
        ]))->implode(DIRECTORY_SEPARATOR);

        $file = Str::substr($hash, 12, 20) . '.' . $avatar->getClientOriginalExtension();

        if (!$this->files->exists($dictionary . DIRECTORY_SEPARATOR . $file)) {
            $avatar->move($dictionary, $file);
        }

        $this->data['path'] = $this->pathSplit($hash, '12,20', Collection::make([
                '../storage/uploads',
            ]))->implode('/') . '.' . $avatar->getClientOriginalExtension();
        $this->data['file_name'] = $realName;

        $this->data['error'] = $error;

        return true;
    }
    /**
     * String split handler.
     *
     * @param string $path
     * @param string $dots
     * @param null   $data
     *
     * @return \Illuminate\Support\Collection|null
     */
    protected function pathSplit($path, $dots, $data = null)
    {
        $dots = explode(',', $dots);
        $data = $data ? $data : new Collection();
        $offset = 0;
        foreach ($dots as $dot) {
            $data->push(Str::substr($path, $offset, $dot));
            $offset += $dot;
        }
        return $data;
    }
}