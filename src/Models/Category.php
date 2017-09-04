<?php
/**
 * The file is part of Notadd
 *
 * @author: AllenGu<674397601@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime: 17-7-24 下午5:08
 */

namespace Notadd\Slide\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ext_slide_categories';

    protected $fillable = [
        'category_name',
        'alias',
    ];

    public function groups()
    {
        return $this->hasMany('Notadd\Slide\Models\Group');
    }
}