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
use Notadd\Slide\Models\Category;
use Notadd\Slide\Models\Group;
use Illuminate\Support\Facades\Storage;

/**
 * Class ConfigurationHandler.
 */
class DeleteGroupHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->validate($this->request, [
            'group_id' => 'required',
        ], [
            'group_id.required' => '图集ID为必传参数',
        ]);

        $group = Group::where('alias', $this->request->input('group_id'))->first();

        $category = Category::find($group->category_id);

        $pictures = $group->pictures()->get();

        $groupPath = $category->path . '/' .$group->path;

        //如果图集为空，那么直接删除图集
        if (count($pictures) == 0)
        {
            $result = $group->delete();

            $deletefiles = $this->container->make('files')->deleteDirectory(base_path('/public/upload/'.$groupPath));

            if ($result&&$deletefiles)
            {
                return $this->withCode(200)->withMessage('删除图集成功');
            }
        }

        //如果图集不为空，那么循环删除该图集的所有图片
        foreach($pictures as $picture)
        {
            $picture->delete();
        }
        //图集图片循环删除完毕后尝试删除当前图集信息

        $deleteDbData = $group->delete();

        $deleteFile = $this->container->make('files')->deleteDirectory(base_path('/public/upload/'.$groupPath));

        if ($deleteDbData && $deleteFile)
        {
            return $this->withCode(200)->withMessage('删除图集成功');
        }else{
            return $this->withCode->withError('删除图集失败');
        }
    }
}
