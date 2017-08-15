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
use Notadd\Slide\Models\Group;
use Notadd\Slide\Models\Category;
use Illuminate\Support\Facades\Storage;

/**
 * Class SetGroupHandler.
 */
class SetGroupHandler extends Handler
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

        //新建图集信息,需要传入分类id
        $this->validate($this->request, [
            'category_id' => 'required',
            'group_name'  => 'required',
            'group_show' => 'required',
        ], [
            'category_id.required' => '分类id为必填参数',
            'group_name.required' => '图集名称不能为空',
            'group_show.required' => '图集显示不能为空'
        ]);
        $cateId = $this->request->get('category_id');
        $category = Category::where('alias', $cateId)->first();
        $group = new Group();
        //如果分类Id没有填写，需要产生一个不重复的分类id别名。
        //如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。
        if ($alias = $this->request->get('group_id')) {
            if ($this->verify($alias)) {
                $this->withCode(403)->withError('分类id在数据库中已存在,请重新定义');
            }
            $group->alias = $alias;
        } else {
            do {
                $random = mt_rand(0, 4999);
            } while ($this->verify($random));
            $group->alias = $random;
        }
        $group->name = $this->request->get('group_name');
        $group->show = $this->request->get('group_show');
        $group->user_id = 1;//默认上传用户Id为1,管理员用户
        $group->category_id = $category->id;
        $group->path = $group->alias;
        $groupPath = $category->path . '/' . $group->alias;
        $createResult = Storage::makeDirectory($groupPath);
        $this->container->make('files')->move(base_path('/storage/app/' . $groupPath), base_path('/public/upload/' . $groupPath));
        //因为移动时只移动了组文件夹，所以要在移动后删除分类文件夹
        if ($this->container->make('files')->exists(base_path('/storage/app/' . $category->path))) {
            $this->container->make('files')->deleteDirectory(base_path('/storage/app/' . $category->path));
        }
        if ($group->save()) {
            $this->withCode(200)->withMessage('图集信息保存成功');
        } else {
            $this->withCode(401)->withError('保存图集信息失败，请稍后重试');
        }
    }

    /** 图集别名验重
     * @para   $alias
     *
     * @return bool
     */
    private function verify($alias)
    {
        $group = Group::where('alias', $alias)->first();
        if ($group instanceof Group) {
            return true;
        } else {
            return false;
        }
    }
}
