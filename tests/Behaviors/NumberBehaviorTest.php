<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Tests\AbstractTestCase;
use Horat1us\Yii\Tests\Mocks\NumberTestMock;

/**
 * Class NumberBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 *
 * @internal
 */
class NumberBehaviorTest extends AbstractTestCase
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
        $this->assertEquals('380001234567', $model->phone);
    }
}
