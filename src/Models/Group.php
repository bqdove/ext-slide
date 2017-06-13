<?php
/**
 * Created by PhpStorm.
 * User: bc021
 * Date: 17-6-13
 * Time: 下午2:13
 */

namespace Notadd\Slide\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'slide_groups';

    public function pictures()
    {
        return $this->hasMany('Picture');
    }

    public function category()
    {
        return $this->belongsTo('Category');
    }
}