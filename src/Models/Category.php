<?php

namespace Notadd\Slide\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'slide_categories';

	protected $fillable = ['category_name', 'alias'];

	public function groups()
    {
        return $this->hasMany('Notadd\Slide\Models\Group');
    }
}