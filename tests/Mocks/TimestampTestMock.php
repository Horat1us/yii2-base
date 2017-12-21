<?php

namespace Horat1us\Yii\Tests\Mocks;

use Horat1us\Yii\Behaviors\FlexibleTimestampBehavior;
use yii\base\Model;

/**
 * Class TimestampTestMock
 * @package Horat1us\Yii\Tests\Mocks
 *
 * @internal
 */
class TimestampTestMock extends Model
{
    /** @var  int */
    public $timestamp;

    /** @var  string */
    public $date1;

    /** @var  string */
    public $date2;

    /** @var string */
    public $format = 'Y/m/d';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'flexibleTimestamp' => [
                'class' => FlexibleTimestampBehavior::class,
                'attributes' => ['timestamp', 'date1', 'date2',],
                'format' => $this->format,
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['timestamp', 'date1', 'date2',], 'date', 'format' => 'php:Y-m-d',],
        ];
    }
}