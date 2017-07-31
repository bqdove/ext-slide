<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-24 下午5:08
 */

namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Picture;
use Notadd\Slide\Models\Group;
use Notadd\Slide\Models\Category;

/**
 * Class UploadHandler.
 */
class UploadHandler extends Handler
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * UploadHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
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
        //获得图集的文件地址
        $this->validate($this->request, [
            'group_id' => 'required',
            'file' => 'required|image',
        ], [
            'group_id.required' => '组图id不能为空',
            'file.image' => '上传文件格式必须为图片格式！',
            'file.required' => '必须上传一个文件！',
        ]);

        $groupId = $this->request->input('group_id');

        $group = Group::where('alias', $groupId)->first();

        if ($group) {
            $groupPath = $group->path;
            $categoryId = $group->category_id;
        }

        $category = Category::find($categoryId);

        $catePath = $category->path;


        $img = $this->request->file('file');
        $realName = $img->getClientOriginalName();
        $error = $img->getError();
        $hash = hash_file('md5', $img->getPathname(), false);
        $groupPath = $catePath. '/' .$groupPath;

        $dictionary = base_path('public/upload/' . $groupPath);
        $random = random_int(0, 9999999);
        $file = Str::substr($hash, 0, 32) . $random . '.' . $img->getClientOriginalExtension();
        if (!$this->files->exists($dictionary . DIRECTORY_SEPARATOR . $file)) {
            $img->move($dictionary, $file);
        }
        $this->data['path'] = url('upload/' . $groupPath . '/' . $hash . $random . '.' . $img->getClientOriginalExtension());
        $this->data['file_name'] = $realName;
        $this->data['error'] = $error;
        $picture = new Picture();
        $picture->path = $this->data['path'];
        $picture->user_id = 1;
        $picture->group_id = $group->id;
        $picture->image_name = $this->data['file_name'];
        $picture->save();

        return true;
    }

    /**
     * String split handler.
     *
     * @param string $path
     * @param string $dots
     * @param null $data
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