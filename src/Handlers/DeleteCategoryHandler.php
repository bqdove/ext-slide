<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iLeyun.org
 * @datetime 2017-06-14 19:45
 */
namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
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
        $mIds       = $this->request->get('ids','');
        $mFiles     = [];

        if(!empty($mIds) && strpos($mIds,',')>=0)
            $mIds  = explode(',',$mIds);


        DB::beginTransaction();
        try{
            $mFiles = DB::table('file_images')->whereIn('id',$mIds)->get();
            DB::table('file_images')->whereIn('id',$mIds)->delete();
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
