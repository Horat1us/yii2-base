<?php

namespace Horat1us\Yii\Traits;

use yii\console;

/**
 * Trait BootstrapMigrations
 * @package Horat1us\Yii\Traits
 */
trait BootstrapMigrations
{
    protected function appendMigrations(
        console\Application $application,
        string $migrationNamespace
    ): void {
        if (!array_key_exists('migrate', $application->controllerMap)) {
            $application->controllerMap['migrate'] = [
                'class' => console\controllers\MigrateController::class,
            ];
        } elseif (is_string($application->controllerMap['migrate'])) {
            $application->controllerMap['migrate'] = [
                'class' => $application->controllerMap['migrate'],
            ];
        }
        $application->controllerMap['migrate']['migrationNamespaces'][] = $migrationNamespace;
    }
}
