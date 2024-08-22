<?php

namespace TimWithers\TeamNotificationSettings;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TimWithers\TeamNotificationSettings\Commands\TeamNotificationSettingsCommand;

class TeamNotificationSettingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-team-notification-settings')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_team_notification_settings_table')
            ->hasCommand(TeamNotificationSettingsCommand::class);
    }
}
