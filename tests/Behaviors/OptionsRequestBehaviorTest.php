<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Behaviors\OptionsRequestBehavior;
use Horat1us\Yii\Tests\AbstractTestCase;
use yii\web;

/**
 * Class OptionsRequestBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 */
class OptionsRequestBehaviorTest extends AbstractTestCase
{
    /**
     * @expectedException \yii\base\ExitException
     */
    public function testExit(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'OPTIONS';
        $behavior = new OptionsRequestBehavior([
            'response' => new class extends web\Response
            {
                public function send(): void
                {
                }
            }
        ]);
        $behavior->check();
    }

    public function testNotExit(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $behavior = new OptionsRequestBehavior();
        $behavior->check();
        $this->assertTrue(true);
    }
}
