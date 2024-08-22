<?php

// config for TimWithers/TeamNotificationSettings
return [
    'notification_settings_model' => \TimWithers\TeamNotificationSettings\Models\NotificationSetting::class,
    'team_model' => 'App\\Models\\Team',
    'user_model' => 'App\\Models\\User',

    'database_queue' => null,

    'mail_queue' => 'default',

    'sms' => [
        'queue' => 'default',
        'enabled' => false,
        'channel_name' => 'vonage',
        'channel_class' => 'Illuminate\\Notifications\\Channels\\VonageSmsChannel',
    ],
];
