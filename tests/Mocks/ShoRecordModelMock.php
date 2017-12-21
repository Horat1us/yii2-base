<?php

namespace Horat1us\Yii\Tests\Mocks;

use Horat1us\Yii\Traits\ShoRecordTrait;
use yii\db\ActiveRecord;

/**
 * Class ShoRecordModelMock
 * @package Horat1us\Yii\Tests\Mocks
 *
 * @internal
 */
class ShoRecordModelMock extends ActiveRecord
{
    use ShoRecordTrait;
}