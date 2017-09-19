<?php

namespace Horat1us\Yii\Tests\Mocks;

use Horat1us\Yii\Behaviors\FlexibleTimestampBehavior;
use yii\base\Model;

/**
 * Class TimestampTestMock
 * @package Horat1us\Yii\Tests\Mocks
 */
class TimestampTestMock extends Model
{
    /** @var  int */
    public $timestamp;

    /** @var  string */
    public $date;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'flexibleTimestamp' => [
                'class' => FlexibleTimestampBehavior::class,
                'attributes' => ['timestamp', 'date',],
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['timestamp', 'date',], 'date', 'format' => 'php:Y-m-d',],
        ];
    }
}