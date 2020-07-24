<?php

namespace App\Infrastructure;

trait EmistEvents
{
    protected function emit($event)
    {
        event($event);
    }
}
