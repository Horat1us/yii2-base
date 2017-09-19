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
     * @return void
     */
    public function testCorrectMapping()
    {
        $this->mockApplication();
        $date1 = Carbon::now()->subDay();
        $date2 = Carbon::now()->subYear();

        $model = new TimestampTestMock([
            'timestamp' => $date1->timestamp,
            'date' => $date2->toDateString(),
        ]);
        $model->validate();

        $this->assertEquals($date1->toDateString(), $model->timestamp);
        $this->assertEquals($date2->toDateString(), $model->date);

        $this->destroyApplication();
    }

    /**
     * @return Application
     */
    protected function mockApplication()
    {
        if (isset(\Yii::$app)) {
            return \Yii::$app;
        }
        \Yii::$container = new Container();
        return \Yii::createObject([
            'class' => Application::class,
            'id' => mt_rand(),
            'basePath' => __DIR__,
        ]);
    }

    /**
     *
     */
    protected function destroyApplication()
    {
        if (\Yii::$app) {
            if (\Yii::$app->has('session', true)) {
                \Yii::$app->session->close();
            }
            if (\Yii::$app->has('db', true)) {
                \Yii::$app->db->close();
            }
        }
        \Yii::$app = null;
        \Yii::$container = new Container();
    }
}