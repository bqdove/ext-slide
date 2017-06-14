<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午6:12
 */

namespace Notadd\Slide\Handlers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\ImagesManager\Models\FileImage;

/**
 * Class ConfigurationHandler.
 */
class EditHandler extends AbstractSetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * SetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(
        Container $container,
        SettingsRepository $settings
    ) {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {

        return [];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $Id = $this->request->get('category_id','');

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
