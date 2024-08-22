<?php

namespace TimWithers\TeamNotificationSettings\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

trait InteractsWithNotificationsTable
{
    /**
     * Flag notification to be persisted to DB. Overwrite to false to disable database notifications
     */
    protected bool $writeToDatabase = true;

    /**
     * Method used to check if notification should be stored.
     * Use $writeToDatabase to change behavior
     */
    final public function storeNotification(): bool
    {
        return $this->writeToDatabase;
    }

    /**
     * Converts an existing database notification to a notification object so that email templates could be viewed by the user in app.
     *
     * @throws \ReflectionException
     */
    public static function fromDatabaseNotification(DatabaseNotification $databaseNotification): static
    {
        // Parameter binding via reflection using the data in the database notification
        $ref = new \ReflectionClass($databaseNotification->type);

        // Build constructor parameters
        $parameters = [];

        $constructor = $ref->getConstructor();
        $requiredParameters = $constructor->getParameters();
        foreach ($requiredParameters as $param) {
            $type = $param->getType();
            $name = $param->getName();
            if ($type !== null && $type->getName() === Model::class && $name === 'team') {
                $parameters[] = config('team-notification-settings.notification_settings_model')::findOrFail($databaseNotification->data[$name.'_id']);
            } elseif (
                $type !== null && is_subclass_of($type->getName(), Model::class)
                && array_key_exists(str($type->getName())->afterLast('\\')->snake().'_id', $databaseNotification->data)
            ) {
                // If the parameter is a model, try to find it by the id in the database notification data
                $parameters[] = $type->getName()::findOrFail($databaseNotification->data[$name.'_id']);
            } elseif (array_key_exists($name, $databaseNotification->data)) {
                // If the parameter is not a model, try to find it in the database notification data
                $parameters[] = $databaseNotification->data[$name];
            } elseif ($param->allowsNull()) {
                // If the parameter is not required, set it to null
                $parameters[] = null;
            } else {
                // If the parameter is required and not found, throw an exception
                throw new Exception($databaseNotification->type.': Cannot initialize parameter "'.$name.'" using database notification data: '.json_encode($databaseNotification->data));
            }
        }

        // Create the notification object
        $notification = new ($databaseNotification->type)(...$parameters);

        // Set public properties
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->name;
            if (array_key_exists($name, $databaseNotification->data)) {
                $notification->$name = $databaseNotification->data[$name];
            }
        }

        return $notification;
    }
}
