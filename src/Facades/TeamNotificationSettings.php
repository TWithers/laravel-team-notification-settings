<?php

namespace TimWithers\TeamNotificationSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TimWithers\TeamNotificationSettings\TeamNotificationSettings
 */
class TeamNotificationSettings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TimWithers\TeamNotificationSettings\TeamNotificationSettings::class;
    }
}
