<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-10 19:41
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Slide\Models\Category;


/**
 * Class GetHandler.
 */
class GetCategoryHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * GetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute($id = null)
    {
        $cateId = $this->request->get('category_id','');

        $category = Category::where('alias', $cateId)->first();

        $this->success()->withData([
            'cate_id' => object_get($category, 'id'),
            'cate_name' => object_get($category, 'name')
        ])->withMessage('获取数据成功！');
    }
}
