<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-24 下午5:08
 */

namespace Notadd\Slide\Listeners;

use Notadd\Slide\Controllers\CategoryController;
use Notadd\Slide\Controllers\GroupController;
use Notadd\Slide\Controllers\PictureController;
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
            $this->router->group(['middleware' => ['cross', 'web'], 'prefix' => 'api/slide'], function () {

                $this->router->group(['prefix' => 'category'],function() {
                    $this->router->post('set', CategoryController::class.'@set');
                    $this->router->post('get', CategoryController::class.'@get');
                    $this->router->post('list',CategoryController::class.'@all');
                    $this->router->post('delete', CategoryController::class.'@delete');
                    $this->router->post('update', CategoryController::class.'@update');
                });

                $this->router->group(['prefix' => 'group'],function() {
                    $this->router->post('set', GroupController::class.'@set');
                    $this->router->post('get', GroupController::class.'@get');
                    $this->router->post('list', GroupController::class.'@all');
                    $this->router->post('delete', GroupController::class.'@delete');
                    $this->router->post('update', GroupController::class.'@update');
                    $this->router->post('show', GroupController::class.'@show');
                });

                $this->router->group(['prefix' => 'picture'],function() {
                    $this->router->post('test',PictureController::class.'@test');
                    $this->router->post('set', PictureController::class.'@set');
                    $this->router->post('get', PictureController::class.'@get');
                    $this->router->post('list', PictureController::class.'@all');
                    $this->router->post('delete', PictureController::class.'@delete');
                    $this->router->post('update', PictureController::class.'@update');
                    $this->router->post('upload',PictureController::class.'@upload');
                });

        });
    }
}
