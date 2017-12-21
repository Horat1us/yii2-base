<?php

namespace Horat1us\Yii\Tests\Mocks;

use Horat1us\Yii\Behaviors\NumberBehavior;
use yii\base\Model;

/**
 * Class NumberTestMock
 * @package Horat1us\Yii\Tests\Mocks
 *
 * @internal
 */
class NumberTestMock extends Model
{
    /** @var  string */
    public $phone;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'numberBehavior' => [
                'class' => NumberBehavior::class,
                'attributes' => 'phone',
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['phone', 'string',],
        ];
    }
}