<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-23 19:44
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
    /**
     * @param \Notadd\Slide\Handlers\GetCategoryHandler $getHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function get(GetCategoryHandler $getHandler)
    {
        return $getHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\SetCategoryHandler $setHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function set(SetCategoryHandler $setHandler)
    {
        return $setHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\DeleteCategoryHandler $deleteCategoryHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(DeleteCategoryHandler $deleteCategoryHandler)
    {
        return $deleteCategoryHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\UpdateCategoryHandler $updateCategoryHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function update(UpdateCategoryHandler $updateCategoryHandler)
    {
        return $updateCategoryHandler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\AllCategoryHandler $allCategoryHandler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function all(AllCategoryHandler $allCategoryHandler)
    {
        return $allCategoryHandler->toResponse()->generateHttpResponse();
    }
}
