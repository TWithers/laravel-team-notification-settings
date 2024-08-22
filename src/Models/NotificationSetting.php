<?php

namespace TimWithers\TeamNotificationSettings\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TimWithers\TeamNotificationSettings\Notifications\TeamNotification;

class NotificationSetting extends Model
{

    protected $casts = [
        'mail_delivery' => 'boolean',
        'sms_delivery' => 'boolean',
    ];

    protected $guarded = [
        'id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(config('team-notification-settings.team_model'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('team-notification-settings.user_model'));
    }

    public static function forTeamUserNotification(Model $team, Model $user, TeamNotification $teamNotification): NotificationSetting
    {

        $notification = self::firstWhere([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'notification' => $teamNotification::class,
        ]);

        if ($notification === null) {
            $defaultConfig = $teamNotification::getOptions()
                ->pluck('default', 'field')
                ->toArray();

            if (! count($defaultConfig)) {
                $defaultConfig = null;
            }

            $notification = self::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
                'notification' => $teamNotification::class,
                'config' => $defaultConfig,
                'mail_delivery' => true,
                'sms_delivery' => false,
            ]);
        }

        return $notification;
    }

    /**
     * We will return the "correct" config no matter the previous settings.
     */
    public function config(): Attribute
    {
        return Attribute::make(
            get: function ($currentOptions, $attributes) {
                if ($currentOptions !== null) {
                    $currentOptions = json_decode($currentOptions, true);
                }

                $validOptions = $attributes['notification']::getOptions()
                    ->pluck('default', 'field')
                    ->toArray();

                if (! count($validOptions)) {
                    return null;
                }

                if ($currentOptions === null) {
                    return $validOptions;
                }

                foreach ($currentOptions as $key => $value) {
                    if (! array_key_exists($key, $validOptions)) {
                        unset($currentOptions[$key]);
                    }
                }

                foreach ($validOptions as $key => $value) {
                    if (! array_key_exists($key, $currentOptions)) {
                        $currentOptions[$key] = $value;
                    }
                }

                return $currentOptions;
            },
            set: function (?array $value) {
                if ($value === null) {
                    return null;
                }

                return json_encode($value);
            },
        );
    }
}
