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
use Notadd\Slide\Models\Category;

/**
 * Class DeleteCategoryHandler.
 */
class DeleteCategoryHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'category_id' => 'required',
        ], [
            'category_id.required' => '分类id为必填参数',
        ]);
        $cateId = $this->request->input('category_id');
        $category = Category::where('alias', $cateId)->first();
        if (!$category) {
            $this->withCode('404')->withError('请重新确认分类Id是否正确');
        }
        $groups = $category->groups()->with('pictures')->get();
        //如果此分类下图集为空，那么直接删除分类
        if (count($groups) == 0) {
            $categoryPath = $category->path;
            $deleteResult = $this->container->make('files')->deleteDirectory(base_path('/public/upload/' . $categoryPath));
            $result = $category->delete();
            if ($result && $deleteResult) {
                return $this->withCode(200)->withMessage('删除分类成功');
            }
        }
        foreach ($groups as $group) {
            $pictures = $group->pictures()->get();
            $groupPath = $category->path . '/' . $group->path;
            //如果该图集下图片数为零，那么删除该图集
            if (count($pictures) == 0) {
                $this->container->make('files')->deleteDirectory(base_path('/public/upload/' . $groupPath));
                $group->delete();
            }
            //如果图集不为空，那么循环删除该图集的所有图片
            foreach ($pictures as $picture) {
                if ($this->container->make('files')->exists($picture->path)) {
                    $this->container->make('files')->delete($picture->path);
                }
                $picture->delete();
            }
            //图集图片循环删除完毕后尝试删除当前图集信息
            $this->container->make('files')->deleteDirectory(base_path('/public/upload/' . $groupPath));
            $group->delete();
        }
        $catePath = $category->path;//注意获取顺序。必须在删除分类信息前获取此字段，否则无法获得。
        //如果当前分类的搜有图集及其所含图片删除完毕后，尝试删除当前想要删除的分类
        $result = $category->delete();
        $deleteResult = $this->container->make('files')->deleteDirectory(base_path('/public/upload/' . $catePath));
        if ($result && $deleteResult) {
            return $this->withCode(200)->withMessage('删除分类成功');
        }
    }
}
