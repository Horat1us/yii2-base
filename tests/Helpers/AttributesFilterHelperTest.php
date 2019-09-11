<?php

namespace Horat1us\Yii\Tests\Helpers;

use Horat1us\Yii\Helpers\AttributesFilterHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class AttributesFilterHelperTest
 * @package Horat1us\Yii\Tests\Helpers
 *
 * @internal
 */
class AttributesFilterHelperTest extends TestCase
{
    const ATTRIBUTE = 'test';

    public function testInvalidFunction()
    {
        $attributes = [
            static::ATTRIBUTE => 'Test',
        ];
        $filters = [
            static::ATTRIBUTE => 'invalidFunc',
        ];
        $this->expectException(\Error::class);
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
