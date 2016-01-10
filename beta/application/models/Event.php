<?php

namespace Model;
use Eloquent;

class Event extends Eloquent {

    public static $timestamps = true;

    public function owner()
    {
        return $this->belongs_to('Model\User');
    }
}
