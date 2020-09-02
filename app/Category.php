<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Define Modal table
	protected $table = 'categories';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the childs for the category.
     */
    public function childs()
    {
    	return $this->hasMany('App\Category', 'parent_id', 'id');
    }
}
