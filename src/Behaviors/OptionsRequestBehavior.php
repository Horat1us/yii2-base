<?php

namespace Horat1us\Yii\Behaviors;

use yii\base\Behavior;
use yii\base\ExitException;
use yii\web\Controller;

/**
 * Class OptionsRequestBehavior
 * @package Horat1us\Yii\Behaviors
 */
class OptionsRequestBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'check',
        ];
    }

    public function check(): void
    {
        if (\Yii::$app->request->method === 'OPTIONS') {
            \Yii::$app->response->send();
            throw new ExitException();
        }
    }
}
