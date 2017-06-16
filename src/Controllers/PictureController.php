<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午2:53
 */
namespace Notadd\Slide\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Slide\Handlers\DeleteHandler;
use Notadd\Slide\Handlers\GetHandler;
use Notadd\Slide\Handlers\UploadHandler;

class PictureController extends Controller
{
    public function upload(UploadHandler $handler)
    {
        header("Access-Control-Allow-Origin: *");
        return $handler->toResponse()->generateHttpResponse();
    }

    public function lists(GetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    public function delete(deleteHandler $deleteHander){
        return $deleteHander->toResponse()->generateHttpResponse();
    }

    private function mk_dir($dir, $mode = 0755)
    {
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!$this->mk_dir(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }
}
