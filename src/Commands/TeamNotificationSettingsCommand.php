<?php

namespace TimWithers\TeamNotificationSettings\Commands;

use Illuminate\Console\Command;

class TeamNotificationSettingsCommand extends Command
{
    public $signature = 'laravel-team-notification-settings';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
