<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Behaviors\OptionsRequestBehavior;
use Horat1us\Yii\Tests\AbstractTestCase;
use Horat1us\Yii\Tests\Mocks\ResponseMock;
use yii\base\ExitException;

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
        $response = new ResponseMock();

        $behavior = new OptionsRequestBehavior([
            'response' => $response
        ]);
        try {
            $behavior->check();
        } catch (ExitException $exception) {
            $this->assertTrue($response->triggered);
            throw $exception;
        }
    }

    public function testNotExit(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $behavior = new OptionsRequestBehavior();
        $behavior->check();
        $this->assertTrue(true);
    }
}
