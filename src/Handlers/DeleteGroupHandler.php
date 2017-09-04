<?php
/**
 * The file is part of Notadd
 *
 * @author        : AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      : 17-7-24 下午5:08
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Support\Collection;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Category;
use Notadd\Slide\Models\Group;

/**
 * Class DeleteGroupHandler.
 */
class DeleteGroupHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        $this->validate($this->request, [
            'group_id' => 'required',
        ], [
            'group_id.required' => '图集ID为必传参数',
        ]);
        $this->beginTransaction();
        $group = Group::query()->where('alias', $this->request->input('group_id'))->first();
        $category = Category::query()->find($group->category_id);
        $pictures = $group->pictures()->get();
        $groupPath = $category->path . '/' . $group->path;
        if ($pictures instanceof Collection && $pictures->isNotEmpty()) {
            //如果图集不为空，那么循环删除该图集的所有图片
            $pictures->each(function ($picture) {
                $picture->delete();
            });
        }
        if (is_dir(base_path('/statics/upload/' . $groupPath))) {
            $this->container->make('files')->deleteDirectory(base_path('/statics/upload/' . $groupPath));
        }
        if ($group->delete()) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('删除图集成功');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('删除图集失败');
        }
    }
}
