<?php
/**
 * This file is part of Notadd.
 *
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-23 19:42
 */
namespace Notadd\Slide\Listeners;

use Notadd\Slide\Controllers\SlideController;
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
                    $this->router->get('get', CategoryController::class.'@get');
                    $this->router->get('list',CategoryController::class.'@all');
                    $this->router->post('delete', CategoryController::class.'@delete');
                    $this->router->post('update', CategoryController::class.'@update');
                });

                $this->router->group(['prefix' => 'group'],function() {
                    $this->router->post('set', GroupController::class.'@set');
                    $this->router->get('get', GroupController::class.'@get');
                    $this->router->get('list', GroupController::class.'@all');
                    $this->router->post('delete', GroupController::class.'@delete');
                    $this->router->post('update', GroupController::class.'@update');
                });

                $this->router->group(['prefix' => 'picture'],function() {
                    $this->router->get('test',PictureController::class.'@test');
                    $this->router->post('set', PictureController::class.'@set');
                    $this->router->get('get', PictureController::class.'@get');
                    $this->router->get('list', PictureController::class.'@all');
                    $this->router->post('delete', PictureController::class.'@delete');
                    $this->router->post('update', PictureController::class.'@update');
                    $this->router->post('upload',PictureController::class.'@upload');
                });
        });
    }
}
