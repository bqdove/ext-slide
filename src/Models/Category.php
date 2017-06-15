<?php

namespace Notadd\Slide\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'slide_categories';

	public function groups()
    {
        return $this->hasMany('Notadd\Slide\Models\Group');
    }
}