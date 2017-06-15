<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Foundation\Yaml\Exceptions\InvalidFileException;
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
        $cateId = $this->request->get('category_id',null);

        if ($cateId){
            $category = Category::where('alias', $cateId)->first();

            $this->success()->withData([
                'cate_id' => object_get($category, 'alias'),
                'cate_name' => object_get($category, 'name')
            ])->withMessage('获取数据成功！');
        }else{
            $categories = Category::all();

            $this->success()->withData($categories)->withMessage('获取数据成功！');
        }

    }
}
