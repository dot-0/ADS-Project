<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Lecture extends Model
{
    //
    protected $collection = 'lectures';
    /**
     * _id
     * uploaded_by
     * target_course
     * title
     * serial
     * content
     */
}
