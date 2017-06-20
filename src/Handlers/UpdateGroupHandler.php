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

/**
 * Class ConfigurationHandler.
 */
class UpdateGroupHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        //更新图集信息,传入group_id,
        if ($groupId = $this->request->query('group_id'))
        {
            $group = Group::where('alias', $groupId)->first();

            if (!$this->request->input('group_name'))
            {
                return $this->withCode('402')->withError('图集名称不能为空');
            }

            if ($alias = $this->request->input('group_id'))
            {
                if($this->verify($alias)){
                    return $this->withCode('403')->withError('图集id在数据库中已存在,请重新定义');
                }

                $group->alias = $alias;
            }else{
                do{
                    $random = mt_rand(0, 4999);
                }while($this->verify($random));

                $group->alias = $random;
            }

            $group->show = $this->request->input('group_show');

            $updateResult = $group->save();

            if ($updateResult)
            {
                return $this->success()->withMessage('更新图集信息成功');
            }
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
