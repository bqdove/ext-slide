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

/**
 * Class UpdateGroupHandler.
 */
class UpdateGroupHandler extends Handler
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
            'id' => 'required',
            'group_name' => 'required',
            'group_show' => 'required',
        ], [
            'id' => '图集id不能为空',
            'group_name.required' => '图集名称不能为空',
            'group_show.required' => '图集可见性不能为空',
        ]);
        //更新图集信息,传入group_id,
        if ($groupId = $this->request->input('id')) {
            $group = Group::query()->where('alias', $groupId)->first();
            if ($alias = $this->request->input('group_id')) {
                if ($this->verify($alias)) {
                    $this->withCode('403')->withError('图集id在数据库中已存在,请重新定义');
                }
                $group->alias = $alias;
            } else {
                do {
                    $random = mt_rand(0, 4999);
                } while ($this->verify($random));
                $group->alias = $random;
            }
            $group->show = $this->request->input('group_show');
            $updateResult = $group->save();
            if ($updateResult) {
                return $this->withCode(200)->withMessage('更新图集信息成功');
            }
        }
    }

    /** 图集别名验重
     * @para   $alias
     *
     * @return bool
     */
    private function verify($alias)
    {
        $group = Group::query()->where('alias', $alias)->first();
        if ($group) {
            return true;
        } else {
            return false;
        }
    }
}
