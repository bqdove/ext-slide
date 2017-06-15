<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;
use Notadd\Slide\Models\Group;

/**
 * Class GetHandler.
 */
class GetGroupHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $cateId = $this->request->get('category_id',null);

        if ($cateId){
            $category = Category::where('alias', $cateId)->first();

            $this->success()->withData([
                'cate_id' => object_get($category, 'id'),
                'cate_name' => object_get($category, 'name')
            ])->withMessage('获取数据成功！');
        }else{
            $categories = Category::all();

            $this->success()->withData($categories)->withMessage('获取数据成功！');
        }

    }
}
