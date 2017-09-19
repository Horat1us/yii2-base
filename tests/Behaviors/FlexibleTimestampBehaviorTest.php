<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Carbon\Carbon;
use Horat1us\Yii\Tests\ApplicationTest;
use Horat1us\Yii\Tests\Mocks\TimestampTestMock;

/**
 * Class FlexibleTimestampBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 */
class FlexibleTimestampBehaviorTest extends ApplicationTest
{
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