<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Notification extends Model
{
    //
    protected $collection = 'notifications';
    /**
     * _id
     * target_user
     * content
     */
}
