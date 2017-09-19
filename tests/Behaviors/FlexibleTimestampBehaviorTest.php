<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Carbon\Carbon;
use Horat1us\Yii\Tests\Mocks\TimestampTestMock;
use PHPUnit\Framework\TestCase;
use yii\di\Container;
use yii\web\Application;

/**
 * Class FlexibleTimestampBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 */
class FlexibleTimestampBehaviorTest extends TestCase
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

    /**
     * @return void
     */
    public function testCorrectMapping()
    {
        $date1 = Carbon::now()->subDay();
        $date2 = Carbon::now()->subYear();

        $model = new TimestampTestMock([
            'timestamp' => $date1->timestamp,
            'date1' => $date2->format('d.m.Y'),
            'date2' => $date2->format('Y-m-d'),
        ]);
        $model->validate();

        $this->assertEquals($date1->format($model->format), $model->timestamp);
        $this->assertEquals($date2->format($model->format), $model->date1);
        $this->assertEquals($date2->format($model->format), $model->date2);
    }
}