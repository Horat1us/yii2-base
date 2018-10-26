<?php


namespace Horat1us\Yii\Tests\Helpers;

use Horat1us\Yii\Helpers\ArrayHelper;
use Horat1us\Yii\Tests\AbstractTestCase;

/**
 * Class ArrayHelperTest
 * @package Horat1us\Yii\Tests\Helpers
 *
 * @internal
 */
class ArrayHelperTest extends AbstractTestCase
{
    public function testPermuting()
    {
        $input = ['a', 'b',];
        $output = ArrayHelper::permute($input);
        $this->assertCount(2, $output);
        $this->assertEquals(['a', 'b',], $output[0]);
        $this->assertEquals(['b', 'a',], $output[1]);
    }

    public function testSome()
    {
        $array = [1, 2, 3];

        $arrayHas2 = ArrayHelper::some($array, function (int $item) {
            return $item === 2;
        });
        $this->assertTrue($arrayHas2);

        $arrayDoesNotHave4 = ArrayHelper::some($array, function (int $item) {
            return $item === 4;
        });
        $this->assertFalse($arrayDoesNotHave4);
    }

    public function testEvery()
    {
        $array = [1, 2, 3];

        $isIntegerArray = ArrayHelper::every($array, 'is_int');
        $this->assertTrue($isIntegerArray);

        $isStringArray = ArrayHelper::every($array, 'is_string');
        $this->assertFalse($isStringArray);
    }
}
