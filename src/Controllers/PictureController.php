<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午2:53
 */
namespace Notadd\Slide\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Slide\Handlers\DeletePictureHandler;
use Notadd\Slide\Handlers\GetPictureHandler;
use Notadd\Slide\Handlers\SetPictureHandler;
use Notadd\Slide\Handlers\UploadHandler;
use Notadd\Slide\Handlers\AllPictureHandler;

class PictureController extends Controller
{
    public function upload(UploadHandler $handler)
    {
        header("Access-Control-Allow-Origin: *");
        return $handler->toResponse()->generateHttpResponse();
    }

    public function test()
    {
        return view('slide::upload');
    }

    public function set(SetPictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    public function all(AllPictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    public function get(GetPictureHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    public function delete(DeletePictureHandler $handler){
        return $handler->toResponse()->generateHttpResponse();
    }

    private function mk_dir($dir, $mode = 0755)
    {
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!$this->mk_dir(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }
}
