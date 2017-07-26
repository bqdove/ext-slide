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