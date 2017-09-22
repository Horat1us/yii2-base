<?php

namespace Horat1us\Yii\Tests\Traits;

use Horat1us\Yii\Tests\Mocks\ShoRecordModelMock;
use PHPUnit\Framework\TestCase;

/**
 * Class ShoRecordTraitTest
 * @package Horat1us\Yii\Tests\Traits
 */
class ShoRecordTraitTest extends TestCase
{
    public function testCorrect()
    {
        $fieldName = ShoRecordModelMock::fieldName('test');
        $this->assertEquals('"sho_record_model_mock"."test"', $fieldName);
    }
}