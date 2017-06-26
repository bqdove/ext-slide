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
use Illuminate\Support\Facades\Storage;


/**
 * Class ConfigurationHandler.
 */
class SetGroupHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        //新建图集信息,不传入group_id,需要传入分类id

        $this->validate($this->request, [
            'category_id' => 'required',
            'group_name' => 'required'
        ], [
            'category_id.required' => '分类ＩＤ为必填参数',
            'group_name.required' => '图集名称不能为空'
        ]);

        $cateId = $this->request->get('category_id');

        $category = Category::where('alias', $cateId)->first();

        $group = new Group();

        //如果分类Id没有填写，需要产生一个不重复的分类id别名。
        //如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。

        if ($alias = $this->request->get('group_id'))
        {
            if($this->verify($alias)){
                return $this->withCode('403')->withError('分类id在数据库中已存在,请重新定义');
            }

            $group->alias = $alias;
        }else{
            do{
                $random = mt_rand(0, 4999);
            }while($this->verify($random));

            $group->alias = $random;
        }

        $group->name = $this->request->get('group_name');

        $group->show = $this->request->get('group_show');

        $group->user_id = 1;//默认上传用户Id为1,管理员用户

        $group->category_id = $category->id;

        $group->path = $group->alias;

        $groupPath = $category->path. '/' . $group->alias;

        $createResult = Storage::makeDirectory($groupPath);

        $this->container->make('files')->move(base_path('/storage/app/' .$groupPath), base_path('/public/upload/'.$groupPath));


        //因为移动时只移动了组文件夹，所以要在移动后删除分类文件夹
        if($this->container->make('files')->exists(base_path('/storage/app/' .$category->path)))
        {
            $this->container->make('files')->deleteDirectory(base_path('/storage/app/' .$category->path));
        }

        if ($group->save()){
            return $this->withCode(200)->withMessage('图集信息保存成功');
        }else{
            return $this->withCode('401')->withError('保存图集信息失败，请稍后重试');
        }
    }

    /** 图集别名验重
     * @para   $alias
     * @return bool
     */
    private function verify($alias)
    {
        $group = Group::where('alias', $alias)->first();
        if ($group)
        {
            return true;
        }else{
            return false;
        }
    }
}
