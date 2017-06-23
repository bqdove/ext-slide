<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Slide\Controllers\CategoryController;
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

        if ($category instanceof Category)
        {
            $this->success()->withData([
                'category_id' => object_get($category, 'alias'),
                'category_name' => object_get($category, 'name')
            ])->withMessage('获取分类信息成功！');
        }elseif(is_null($category)){
            $this->withCode(402)->withError('分类不存在');
        }else{
            $this->withCode('404')->withError('获取数据失败');
        }
    }
}
