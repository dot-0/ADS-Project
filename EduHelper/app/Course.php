<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Course extends Model
{
    //
    protected $collection = 'courses';
    /**
     * _id
     * title
     * description
     * uploaded_by
     * rating
     */
}
