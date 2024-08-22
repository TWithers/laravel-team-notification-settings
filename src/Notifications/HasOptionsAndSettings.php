<?php

namespace TimWithers\TeamNotificationSettings\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TimWithers\TeamNotificationSettings\Attributes\ConfigurationOption;

trait HasOptionsAndSettings
{
    /**
     * Flag that indicates if the notification has settings.
     * Overwrite to false to disable notification settings for this notification.
     */
    protected bool $hasSettings = true;

    /**
     * This method can be overridden to validate whether a notification should be sent to a user based on their specified notification settings.
     * Returning false will cause the notification to be ignored, both database and mail channels.
     */
    public function validateNotificationSetting(Model $notificationSetting): bool
    {
        return true;
    }



    /**
     * Method used to check if notification has stored settings.
     * Without stored settings, every team user will receive the notification.
     */
    final public function hasSettings(): bool
    {
        return $this->hasSettings;
    }

    /**
     * Returns a collection of ConfigurationOptions for the notification
     *
     * @return Collection<ConfigurationOption>
     */
    public static function getOptions(): Collection
    {
        $refClass = new \ReflectionClass(static::class);

        return collect($refClass->getAttributes())->map->newInstance();
    }
}
