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

/**
 * Class AllGroupHandler.
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
            'category_id' => 'required',
        ], [
            'category_id.required' => '分类Id为必传参数',
        ]);
        $categoryId = $this->request->input('category_id');

        $category = Category::where('alias', $categoryId)->first();

        $groups = Group::where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate(3)->toArray();

        $this->withCode(200)->withData($groups)->withMessage('获取图集列表成功！');
    }
}
