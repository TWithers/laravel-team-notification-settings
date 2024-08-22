<?php

namespace TimWithers\TeamNotificationSettings\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Str;
use TimWithers\TeamNotificationSettings\Notifications\TeamNotification;

class TeamMailChannel
{
    protected mixed $smsChannel;

    protected bool $smsEnabled = false;

    public function __construct(
        protected MailChannel $mailChannel,
        protected DatabaseChannel $databaseChannel,
    ) {
        if (config('team-notification-settings.channels.sms.enabled')) {
            $this->smsChannel = app(config('team-notification-settings.channels.sms.channel_class'));
            $this->smsEnabled = true;
        }
    }

    public function send(Model $team, TeamNotification $notification): void
    {
        if (! $notification->hasSettings()) {
            $team->teamUserRelation()->each(function ($user) use ($notification) {
                if ($notification->storeNotification()) {
                    // Each notification needs a unique ID. The UUID is populated previously, so saving it twice throws and error
                    // \Illuminate\Notifications\NotificationSender::sendNow($user, $notification); Line 102
                    $notification->id = Str::uuid()->toString();
                    $this->databaseChannel->send($user, $notification);
                }

                $this->mailChannel->send($user, $notification);

                if ($this->smsEnabled) {
                    $this->smsChannel->send($user, $notification);
                }
            });

            return;
        }

        $settings = $team->getNotificationSettingsForTeamUsers($notification);

        foreach ($settings as $setting) {
            if ($notification->validateNotificationSetting($setting)) {
                if ($notification->storeNotification()) {
                    $this->databaseChannel->send($setting->user, $notification);
                }

                if ($setting->mail_delivery) {
                    $this->mailChannel->send($setting->user, $notification);
                }

                if ($this->smsEnabled && $setting->sms_delivery) {
                    $this->smsChannel->send($setting->user, $notification);
                }
            }
        }
    }
}
