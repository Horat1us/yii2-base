<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Behaviors\OptionsRequestBehavior;
use Horat1us\Yii\Tests\AbstractTestCase;
use yii\base\ExitException;
use yii\web;

/**
 * Class OptionsRequestBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 */
class OptionsRequestBehaviorTest extends AbstractTestCase
{
    /** @var OptionsRequestBehavior */
    protected $behavior;

    public function setUp(): void
    {
        parent::setUp();
        $this->behavior = new OptionsRequestBehavior([
            'request' => new class extends web\Request
            {
                public function setMethod(string $method): void
                {
                    $this->method = $method;
                }
            },
            'response' => new class extends web\Response
            {
                public $triggered = false;

                public function send(): void
                {
                    $this->triggered = true;
                }
            }
        ]);
    }

    public function testExit(): void
    {
        $this->behavior->request->method = 'OPTIONS';
        $this->expectException(\yii\base\ExitException::class);
        try {
            $this->behavior->check();
        } catch (ExitException $exception) {
            $this->assertTrue($this->behavior->response->triggered);
            throw $exception;
        }
    }

    public function testNotExit(): void
    {
        $this->behavior->request->method = 'GET';
        $this->behavior->check();
        $this->assertFalse($this->behavior->response->triggered);
    }
}
