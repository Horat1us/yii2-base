<?php

namespace Horat1us\Yii\Tests\Helpers;

use Horat1us\Yii\Helpers\UrlHelper;
use Horat1us\Yii\Tests\AbstractTestCase;

/**
 * Class UrlHelperTest
 * @package Horat1us\Yii\Tests\Helpers
 * @internal
 */
class UrlHelperTest extends AbstractTestCase
{
    public function testAppend()
    {
        $url = 'https://horatius.pro/abc/c?route=1&multiple%5B0%5D=1';
        $processedUrl = UrlHelper::append($url, [
            'action' => 'undefined',
            'multiple' => [
                2
            ],
        ]);
        $this->assertEquals(
            'https://horatius.pro/abc/c?route=1&multiple%5B0%5D=2&action=undefined',
            $processedUrl
        );

        $url = "//google.com";
        $processedUrl = UrlHelper::append($url, [
            'a' => 'b',
        ]);
        $this->assertEquals(
            "http://google.com?a=b",
            $processedUrl
        );
    }
}
