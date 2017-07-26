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
 * Class Picture.
 */
class Picture extends Model
{
    /**
     * @var string
     */
    protected $table = 'slide_pictures';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Notadd\Slide\Models\Group');
    }
}