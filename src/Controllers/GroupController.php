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
use Notadd\Slide\Handlers\GetGroupHandler;
use Notadd\Slide\Handlers\SetGroupHandler;
use Notadd\Slide\Handlers\DeleteGroupHandler;
use Notadd\Slide\Handlers\UpdateGroupHandler;
use Notadd\Slide\Handlers\AllGroupHandler;

/**
 * Class CategoryController.
 */
class GroupController extends Controller
{
    /**
     * @param \Notadd\Slide\Handlers\GetGroupHandler $getHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function get(GetGroupHandler $getHandler)
    {
        return $getHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\AllGroupHandler $allGroupHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function all(AllGroupHandler $allGroupHandler)
    {
        return $allGroupHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\SetGroupHandler $setHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function set(SetGroupHandler $setHandler)
    {
        return $setHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\DeleteGroupHandler $deleteHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(DeleteGroupHandler $deleteHandler)
    {
        return $deleteHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\ShowGroupHandler $showHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function show(ShowGroupHandler $showHandler)
    {
        return $showHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\UpdateGroupHandler $updateGroupHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function update(UpdateGroupHandler $updateGroupHandler)
    {
        return $updateGroupHandler->toResponse()->generateHttpResponse();
    }
}
