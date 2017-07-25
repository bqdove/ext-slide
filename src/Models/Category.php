<?php
/**
 * This file is part of Notadd.
 *
 * @author Allen <674397601@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-06-23 19:44
 */
namespace Notadd\Slide\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'slide_categories';

    protected $fillable = [
        'category_name',
        'alias',
    ];

    public function groups()
    {
        return $this->hasMany('Notadd\Slide\Models\Group');
    }
}