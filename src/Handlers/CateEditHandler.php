<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午6:12
 */

namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Slide\Models\Category;

/**
 * Class ConfigurationHandler.
 */
class CateEditHandler extends AbstractSetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * SetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(
        Container $container,
        SettingsRepository $settings
    ) {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {

        return [];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $cateId = $this->request->get('category_id','');

        $category = Category::where('alias', $cateId)->first();

    }
}
