<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Question extends Model
{
    //
    protected $collection = 'questions';
    /**
     * _id
     * question
     * target_lecture
     */
}
