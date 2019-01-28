<?php

namespace Horat1us\Yii\Exceptions\Behavior;

use Throwable;
use yii\base;

/**
 * Class ExtractException
 * @package Horat1us\Yii\Exceptions\Behavior
 */
class ExtractException extends base\InvalidConfigException
{
    /** @var base\Behavior */
    protected $behavior;

    /** @var string */
    protected $targetClass;

    public function __construct(
        base\Behavior $behavior,
        string $targetClass,
        int $code = 0,
        Throwable $previous = null
    ) {
        $message = \get_class($behavior) . " can be applied only to {$targetClass}";
        parent::__construct($message, $code, $previous);

        $this->behavior = $behavior;
        $this->targetClass = $targetClass;
    }

    public function getBehavior(): base\Behavior
    {
        return $this->behavior;
    }

    public function getTargetClass(): string
    {
        return $this->targetClass;
    }
}
