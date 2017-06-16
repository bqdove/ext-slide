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
                    $this->router->get('set', CategoryController::class.'@set');
                    $this->router->get('get', CategoryController::class.'@get');
                    $this->router->get('delete', CategoryController::class.'@delete');

                });

                $this->router->group(['prefix' => 'group'],function() {
                    $this->router->get('set', GroupController::class.'@set');
                    $this->router->get('get', GroupController::class.'@get');
                    $this->router->get('delete', GroupController::class.'@delete');
                });

                $this->router->group(['prefix' => 'picture'],function() {
                    $this->router->get('test',PictureController::class.'@test');
                    $this->router->post('upload',PictureController::class.'@upload');
                    $this->router->get('edit', PictureController::class.'@getEdit');
                    $this->router->post('edit', PictureController::class.'@postEdit');
                    $this->router->post('delete', PictureController::class.'@postDelete');
                });
        });
    }
}
