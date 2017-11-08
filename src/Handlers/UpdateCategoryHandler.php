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
use Notadd\Slide\Models\Group;
use Illuminate\Support\Facades\Storage;

/**
 * Class UpdateCategoryHandler.
 */
class UpdateCategoryHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        //更新一个分类
        $this->validate($this->request, [
            'category_name' => 'required',
            'category_id' => 'required',
        ], [
            'category_name.required' => '分类名为必填字段',
            'category_id' => '分类id不能为空',
        ]);
        $category = Category::query()->where('alias', $this->request->input('category_id'))->first();
        if ($category instanceof Category) {
            $category->name = $this->request->input('category_name');
        } else {
            $this->withError(404)->withError('未找到此id分类');
        }
        $updateResult = $category->save();
        if ($updateResult) {
            $this->withCode(200)->withMessage('更新分类信息成功');
        } else {
            $this->withError(403)->withError('更新分类信息失败');
        }
    }
}
