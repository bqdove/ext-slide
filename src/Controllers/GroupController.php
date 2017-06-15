<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-13 14:59
 */
namespace Notadd\Slide\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Slide\Handlers\ShowGroupHandler;
use Notadd\Slide\Models\Group;

/**
 * Class CategoryController.
 */
class GroupController extends Controller
{
    public function get(GetGroupHandler $getHandler){
        return $getHandler->toResponse()->generateHttpResponse();
    }

    public function set(SetGroupHandler $setHandler){
        return $setHandler->toResponse()->generateHttpResponse();
    }

    public function delete(DeleteGroupHandler $deleteHandler)
    {
        return $deleteHandler->toResponse()->generateHttpResponse();
    }

    public function show(ShowGroupHandler $showHandler)
    {
        return $showHandler->toResponse()->generateHttpResponse();
    }
}
