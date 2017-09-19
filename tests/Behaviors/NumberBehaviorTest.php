<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Tests\ApplicationTest;
use Horat1us\Yii\Tests\Mocks\NumberTestMock;

/**
 * Class NumberBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 */
class NumberBehaviorTest extends ApplicationTest
{
    /**
     * @return void
     */
    public function testMapping()
    {
        $phone = '+38 (000) 123-45-67';
        $model = new NumberTestMock([
            'phone' => $phone,
        ]);
        $model->validate();
        $this->assertEquals(preg_replace('/\D/', '', $phone), $model->phone);
    }
}