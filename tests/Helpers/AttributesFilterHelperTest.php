<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 11.08.17
 * Time: 13:09
 */

namespace Horat1us\Yii\Tests\Helpers;

use Horat1us\Yii\Helpers\AttributesFilterHelper;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;

/**
 * Class AttributesFilterHelperTest
 * @package Horat1us\Yii\Tests\Helpers
 */
class AttributesFilterHelperTest extends TestCase
{
    const ATTRIBUTE = 'test';

    /**
     * @expectedException Error
     */
    public function testInvalidFunction()
    {
        $attributes = [
            static::ATTRIBUTE => 'Test',
        ];
        $filters = [
            static::ATTRIBUTE => 'invalidFunc',
        ];

        AttributesFilterHelper::apply($attributes, $filters);
    }

    public function testCorrectMap()
    {
        $initialValue = '123';
        $attributes = [
            static::ATTRIBUTE => $initialValue,
        ];
        $filters = [
            static::ATTRIBUTE => 'intval',
        ];

        $output = AttributesFilterHelper::apply($attributes, $filters);
        $this->assertArrayHasKey(static::ATTRIBUTE, $output);
        $this->assertTrue($initialValue !== $output[static::ATTRIBUTE]);
        $this->assertTrue((int)$initialValue === $output[static::ATTRIBUTE]);
    }
}