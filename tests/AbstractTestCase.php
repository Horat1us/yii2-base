<?php

namespace Horat1us\Yii\Tests;

use \PHPUnit\Framework\TestCase;
use yii\di\Container;
use yii\web\Application;

/**
 * Class ApplicationTest
 * @package Horat1us\Yii\Tests
 *
 * @internal
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Create new application instance if it doesn't exist.
     * @return void
     */
    public function setUp()
    {
        if (isset(\Yii::$app)) {
            return;
        }
        \Yii::$container = new Container();
        \Yii::createObject([
            'class' => Application::class,
            'id' => mt_rand(),
            'basePath' => __DIR__,
        ]);
    }

    /**
     * Clear created application.
     * @return void
     */
    public function tearDown()
    {
        \Yii::$app = null;
        \Yii::$container = new Container();
    }
}