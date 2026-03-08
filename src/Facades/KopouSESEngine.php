<?php

namespace Kopou\SESEngine\Facades;

use Illuminate\Support\Facades\Facade;

class KopouSESEngine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kopou-ses-engine';
    }
}
