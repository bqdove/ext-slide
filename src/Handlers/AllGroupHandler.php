<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Group;
use Notadd\Slide\Models\Category;


/**
 * Class GetHandler.
 */
class AllGroupHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'category_id' => 'required'
        ],[
            'category_id.required' => '分类Id为必传参数'
        ]);

        $categoryId = $this->request->input('category_id');

        $category = Category::where('alias', $categoryId)->first();

        $groups = Group::where('category_id', $category->id)->paginate(30)->toArray();

        $this->withCode(200)->withData($groups)->withMessage('获取图集列表成功！');
    }
}
