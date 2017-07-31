<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-24 下午5:08
 */

namespace Notadd\Slide\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Slide\Handlers\DeletePictureHandler;
use Notadd\Slide\Handlers\GetPictureHandler;
use Notadd\Slide\Handlers\SetPictureHandler;
use Notadd\Slide\Handlers\UploadHandler;
use Notadd\Slide\Handlers\AllPictureHandler;
use Notadd\Slide\Handlers\UpdatePictureHandler;

/**
 * Class PictureController.
 */
class PictureController extends Controller
{
    /**
     * @param \Notadd\Slide\Handlers\UploadHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function upload(UploadHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function test()
    {
        return view('slide::upload');
    }

    /**
     * @param \Notadd\Slide\Handlers\SetPictureHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function set(SetPictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\AllPictureHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function all(AllPictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\GetPictureHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function get(GetPictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Slide\Handlers\DeletePictureHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(DeletePictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param     $dir
     * @param int $mode
     *
     * @return bool
     */
    private function mk_dir($dir, $mode = 0755)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) return true;
        if (!$this->mk_dir(dirname($dir), $mode)) return false;

        return @mkdir($dir, $mode);
    }

    public function update(UpdatePictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
