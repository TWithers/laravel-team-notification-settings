<?php

namespace TimWithers\TeamNotificationSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use TimWithers\TeamNotificationSettings\Notifications\TeamNotification;

trait TeamNotifiable
{
    use Notifiable;

    public function teamUserRelation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(config('team-notification-settings.user_model'));
    }

    public function getNotificationSettingsForTeamUsers(TeamNotification $notification): Collection
    {
        return $this->teamUserRelation->map(fn (Model $user) => NotificationSetting::forTeamUserNotification($this, $user, $notification)->load('user'));
    }
}
