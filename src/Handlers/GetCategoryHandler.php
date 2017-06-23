<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Models\Category;


/**
 * Class GetHandler.
 */
class GetCategoryHandler extends Handler
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
        ], [
            'category_id.required' => '请传入分类ID'
        ]);

        $cateId = $this->request->input('category_id');

        $category = Category::where('alias', $cateId)->first();

        $this->success()->withData([
            'category_id' => object_get($category, 'alias'),
            'category_name' => object_get($category, 'name')
        ])->withMessage('获取数据成功！');
    }
}
