<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Tag extends Model
{
    //
    protected $collection = 'tags';
    /**
     * _id
     * name
     * course_list
     */
}
