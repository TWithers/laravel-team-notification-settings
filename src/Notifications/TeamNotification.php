<?php

namespace TimWithers\TeamNotificationSettings\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TimWithers\TeamNotificationSettings\Channels\TeamMailChannel;

/**
 * If notification_setting is more than a on/off switch, use App\Lib\Attributes\Notifications\Configuration attributes to configure each configuration option
 */
abstract class TeamNotification extends Notification implements ShouldQueue
{
    use HasOptionsAndSettings, InteractsWithNotificationsTable, Queueable;

    /**
     * Create a new notification instance. This should only be used to populate class variables. No logic should be placed here.
     * All view logic should be placed in the initialize() method.
     *
     * @return void
     */
    public function __construct(
        protected Model $team
    ) {
        //
    }

    /**
     * View logic should be placed here.
     * This method is called only during dispatching the notification.
     * Any logic placed here will be executed every time the notification is sent.
     * This will not be called when the notification is retrieved from the database.
     *
     * @return $this
     */
    public function initialize(): static
    {
        return $this;
    }

    /**
     * Get the array representation of the notification.
     * Persisted to database to generate notification later.
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'team_id' => $this->team->id,
        ];
    }

    /**
     * The TeamMailChannel will notify every user that belongs to the team based on individual settings
     * If a notification doesn't have a notification_setting, it will be sent automatically to all team individuals
     */
    public function via(mixed $notifiable): array
    {
        return [TeamMailChannel::class];
    }

    public function viaQueues(): array
    {
        return array_filter([
            'mail' => config('team-notification-settings.mail_queue'),
            config('team-notification-settings.channels.sms.channel_name') => config('team-notification-settings.channels.sms.queue'),
            'database' => config('team-notification-settings.database_queue'),
        ]);
    }

    /**
     * Must be implemented by child class.
     *
     * Inline MailMessage composition must use `->template('emails.layouts.notificationInlineLayout')` to ensure notification layout matches
     * MailMessage using `->markdown()` views must use the <x-notification-layout>
     */
    abstract public function toMail(mixed $notifiable): MailMessage;

    /**
     * Returns the name of the notification for display within the app.
     */
    abstract public static function getDisplayName(DatabaseNotification $notification): string;
}
