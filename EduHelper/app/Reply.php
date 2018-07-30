<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Reply extends Model
{
    //
    protected  $collection = 'replies';
    /**
     * _id
     * target_question
     * answer
     */
}
