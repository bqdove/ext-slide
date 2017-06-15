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
class SetGroupHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $group = new Group();

        if (!$this->request->input('group_name'))
        {
            $this->withCode('402')->withMessage('图集名称不能为空');
        }
//        如果分类Id没有填写，需要产生一个不重复的分类id别名。
//        如果分类Id用户自定义了，需要验证是否与数据库里的数据重复。
        if ($alias = $this->request->input('group_id'))
        {
            if($this->verify($alias)){
                $this->withCode('403')->withMessage('分类id在数据库中已存在,请重新定义');
            }

            $group->alias = $alias;
        }else{
            do{
                $random = mt_rand(0, 1999);
            }while($this->verify($random));

            $group->alias = $random;
        }

        $group->name = $this->request->input('group_name');

        $group->show = $this->request->input('group_show');

        $group->user_id = 1;//默认上传用户Id为1,管理员用户

        if ($group->save()){
            $this->success()->withMessage('图集信息保存成功');
        }else{
            $this->withCode('401')->withMessage('保存图集信息失败，请稍后重试');
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
