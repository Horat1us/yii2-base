<?php

declare(strict_types=1);

namespace Horat1us\Yii;

use yii\base;
use yii\di;

/**
 * Class ComposeBootstrap
 * @package Horat1us\Yii
 */
class BootstrapGroup extends base\BaseObject implements base\BootstrapInterface
{
    /**
     * All of this bootstraps will be used.
     * @var array|string|base\BootstrapInterface references
     */
    public $items = [];

    /**
     * @param base\Application $app
     * @throws base\InvalidConfigException
     */
    public function bootstrap($app): void
    {
        foreach ($this->items as $reference) {
            /** @var base\BootstrapInterface $bootstrap */
            $bootstrap = di\Instance::ensure($reference, base\BootstrapInterface::class);
            $bootstrap->bootstrap($app);
        }
    }
}
