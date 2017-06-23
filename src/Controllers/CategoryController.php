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
use Notadd\Slide\Handlers\UpdateCategoryHandler;
use Notadd\Slide\Handlers\GetCategoryHandler;
use Notadd\Slide\Handlers\SetCategoryHandler;
use Notadd\Slide\Handlers\DeleteCategoryHandler;
use Notadd\Slide\Handlers\AllCategoryHandler;


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

    public function update(UpdateCategoryHandler $updateCategoryHandler)
    {
        return $updateCategoryHandler->toResponse()->generateHttpResponse();
    }

    public function all(AllCategoryHandler $allCategoryHandler)
    {
        return $allCategoryHandler->toResponse()->generateHttpResponse();
    }
}
