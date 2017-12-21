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
}