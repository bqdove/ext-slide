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

/**
 * Class Group.
 */
class Group extends Model
{
    /**
     * @var string
     */
    protected $table = 'slide_groups';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures()
    {
        return $this->hasMany('Notadd\Slide\Models\Picture');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Notadd\Slide\Models\Category');
    }
}