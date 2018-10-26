<?php

namespace Horat1us\Yii\Behaviors;

use yii\base;
use yii\web;
use yii\di;

/**
 * Class OptionsRequestBehavior
 * @package Horat1us\Yii\Behaviors
 */
class OptionsRequestBehavior extends base\Behavior
{
    /** @var string|array|web\Request */
    public $request = 'request';

    /** @var string|array|web\Response */
    public $response = 'response';

    public function init(): void
    {
        parent::init();
        $this->request = di\Instance::ensure($this->request, web\Request::class);
        $this->response = di\Instance::ensure($this->response, web\Response::class);
    }

    public function events(): array
    {
        return [
            web\Controller::EVENT_BEFORE_ACTION => 'check',
        ];
    }

    public function check(): void
    {
        if ($this->request->method === 'OPTIONS') {
            $this->response->send();
            throw new base\ExitException();
        }
    }
}
