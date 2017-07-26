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
 * Class AllCategoryHandler.
 */
class AllCategoryHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $categories = Category::OrderBy('created_at', 'desc')->paginate(3)->toArray();

        $this->withCode(200)->withData($categories)->withMessage('获取数据成功！');
    }
}
