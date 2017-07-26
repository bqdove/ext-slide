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
use Notadd\Slide\Models\Category;

/**
 * Class GetCategoryHandler.
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
            'category_id' => 'required',
        ], [
            'category_id.required' => '请传入分类ID',
        ]);
        $cateId = $this->request->input('category_id');
        $category = Category::where('alias', $cateId)->first();
        if ($category instanceof Category) {
            $this->withCode(200)->withData([
                'category_id'   => object_get($category, 'alias'),
                'category_name' => object_get($category, 'name'),
            ])->withMessage('获取分类信息成功！');
        } else if (is_null($category)) {
            $this->withCode(402)->withError('分类不存在');
        } else {
            $this->withCode('404')->withError('获取数据失败');
        }
    }
}
