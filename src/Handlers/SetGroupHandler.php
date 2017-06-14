<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;
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
        $cateId = $this->request->get('category_id','');

        $category = Category::where('alias', $cateId)->first();

        $category->name = $this->request->input('cate_name');

        $category->alias = $this->request->input('cate_id');

        $this->success()->withMessage('更新分类'.object_get($category, 'name').'数据成功！');

        return true;
    }
}
