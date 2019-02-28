<?php

declare(strict_types=1);

namespace Horat1us\Yii\Tests;

use PHPUnit\Framework\TestCase;
use Horat1us\Yii\BootstrapGroup;
use yii\console;
use yii\base;

/**
 * Class BootstrapGroupTest
 * @package Horat1us\Yii\Tests
 */
class BootstrapGroupTest extends TestCase
{
    public function testRunningItems(): void
    {
        /** @var console\Application $app */
        $app = $this->createMock(console\Application::class);
        $group = new BootstrapGroup();

        $child = $this->createMock(BootstrapGroup::class);

        $child
            ->expects($this->exactly(2))
            ->method('bootstrap')
            ->with($app);

        $group->items = [
            $child,
            $child,
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        $group->bootstrap($app);
    }

    public function testInvalidReference(): void
    {
        /** @var console\Application $app */
        $app = $this->createMock(console\Application::class);
        $group = new BootstrapGroup([
            'items' => [
                new \stdClass,
            ],
        ]);

        $this->expectException(base\InvalidConfigException::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $group->bootstrap($app);
    }
}
