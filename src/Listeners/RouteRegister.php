<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-23 19:42
 */
namespace Notadd\Slide\Listeners;

use Notadd\Slide\Controllers\SlideController;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Register.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/baidu'], function () {
            $this->router->post('get', BaiduController::class . '@get');
            $this->router->post('set', BaiduController::class . '@set');
        });
    }
}
