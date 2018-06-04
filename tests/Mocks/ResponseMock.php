<?php

namespace Horat1us\Yii\Tests\Mocks;

use yii\web\Response;

/**
 * Class ResponseMock
 * @package Horat1us\Yii\Tests\Mocks
 */
class ResponseMock extends Response
{
    public $triggered = false;

    public function send(): void
    {
        $this->triggered = true;
    }
}
