<?php

namespace Horat1us\Yii\Tests\Exceptions\Behavior;

use Horat1us\Yii\Exceptions\Behavior\ExtractException;
use Horat1us\Yii\Tests\AbstractTestCase;
use yii\base;

/**
 * Class ExtractExceptionTest
 * @package Horat1us\Yii\Tests\Exceptions\Behavior
 */
class ExtractExceptionTest extends AbstractTestCase
{
    public function testException(): void
    {
        $behavior = new base\Behavior();
        $exception = new ExtractException($behavior, base\Model::class);
        $this->assertEquals($behavior, $exception->getBehavior());
        $this->assertEquals(base\Model::class, $exception->getTargetClass());
        $this->assertEquals(
            'yii\\base\\Behavior can be applied only to yii\\base\\Model',
            $exception->getMessage()
        );
    }
}
