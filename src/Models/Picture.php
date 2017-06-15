<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午2:14
 */

namespace Notadd\Slide\Models;


use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'slide_pictures';

    public function group()
    {
        return $this->belongsTo('Notadd\Slide\Models\Group');
    }
}