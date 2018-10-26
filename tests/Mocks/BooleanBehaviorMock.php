<?php

namespace Horat1us\Yii\Tests\Mocks;

use Horat1us\Yii\Behaviors\BooleanBehavior;
use yii\db\ActiveRecord;

/**
 * Class BooleanBehaviorMock
 * @package Horat1us\Yii\Tests\Mocks
 *
 * @internal
 */
class BooleanBehaviorMock extends ActiveRecord
{
    /** @var  int */
    public $intValue;

    /** @var  bool */
    public $boolValue;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'intBooleanBehavior' => [
                'class' => BooleanBehavior::class,
                'attributes' => 'intValue',
                'returnType' => BooleanBehavior::RETURN_TYPE_INT,
            ],
            'boolBooleanBehavior' => [
                'class' => BooleanBehavior::class,
                'attributes' => 'boolValue',
                'returnType' => BooleanBehavior::RETURN_TYPE_BOOL,
            ],
        ];
    }
}
