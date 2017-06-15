<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iLeyun.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Support\Facades\Storage;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Slide\Models\Category;

/**
 * Class ConfigurationHandler.
 */
class DeleteCategoryHandler extends AbstractSetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $cateId = $this->request->input('category_id');

        $category = Category::where('alias', $cateId)->first();

        if (!$category)
        {
            return false;
        }
        Category::beginTransaction();
        try{

            Category->where('alias',$cateId)->delete();
        }catch (\PDOException $PDOException){
            DB::rollback();
            $this->messages->push($this->translator->trans('ImagesManager::delete.fail'));
            return false;
        }
        try{
            if($mFiles)
                foreach ($mFiles->toArray() as $v){//如果有，则删除文件
                    if(Storage::disk('public')->exists($v->path)){
                        Storage::disk('public')->delete($v->path);
                    }

                }
        }catch (\Exception $exception){
            DB::rollback();
            $this->messages->push($this->translator->trans('ImagesManager::delete.fail'));
            return false;
        }

        DB::commit();
        $this->messages->push($this->translator->trans('ImagesManager::delete.success'));
        return true;

    }
}
