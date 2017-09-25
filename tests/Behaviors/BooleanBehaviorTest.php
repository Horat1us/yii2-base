<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Tests\Mocks\BooleanBehaviorMock;
use PHPUnit\Framework\TestCase;

/**
 * Class BooleanBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 */
class BooleanBehaviorTest extends TestCase
{
    public function testInt()
    {
        $model = new BooleanBehaviorMock();
        $model->intValue = '1';
        $model->validate();
        $this->assertTrue($model->intValue === 1);

        $model->intValue = true;
        $model->validate();
        $this->assertTrue($model->intValue === 1);

        $model->intValue = 'true';
        $model->validate();
        $this->assertTrue($model->intValue === 1);
    }

    public function testBool()
    {
        $model = new BooleanBehaviorMock();
        $model->boolValue = '1';
        $model->validate();
        $this->assertTrue($model->boolValue);

        $model->boolValue = 1;
        $model->validate();
        $this->assertTrue($model->boolValue);

        $model->boolValue = 'true';
        $model->validate();
        $this->assertTrue($model->boolValue);
    }
}