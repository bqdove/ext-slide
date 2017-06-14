<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-23 19:44
 */
namespace Notadd\Slide\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Slide\Handlers\CateEditHandler;
use Notadd\Slide\Handlers\GetCategoryHandler;
use Notadd\Slide\Handlers\SetCategoryHandler;

/**
 * Class CategoryController.
 */

class CategoryController extends Controller
{
    public function get(GetCategoryHandler $getHandler){
        return $getHandler->toResponse()->generateHttpResponse();
    }

    public function set(SetCategoryHandler $setHandler){
        return $setHandler->toResponse()->generateHttpResponse();
    }

    public function delete(DeleteCategoryHandler $deleteCategoryHandler)
    {
        return $deleteCategoryHandler->toResponse()->generateHttpResponse();
    }
}
