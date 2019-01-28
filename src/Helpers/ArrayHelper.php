<?php

namespace Horat1us\Yii\Helpers;

use yii\helpers\ArrayHelper as YiiArrayHelper;

/**
 * Class ArrayHelper
 * @package Horat1us\Yii\Helpers
 */
class ArrayHelper extends YiiArrayHelper
{
    /**
     * @param $items
     * @param array $perms
     * @return array
     */
    public static function permute($items, $perms = [])
    {
        if (empty($items)) {
            $return = [$perms];
        } else {
            $return = [];
            for ($i = \count($items) - 1; $i >= 0; --$i) {
                $newItems = $items;
                $newPerms = $perms;
                list($foo) = \array_splice($newItems, $i, 1);
                \array_unshift($newPerms, $foo);
                $return = \array_merge($return, static::permute($newItems, $newPerms));
            }
        }
        return $return;
    }

    public static function every(array $items, callable $condition): bool
    {
        // we need reflection to be able pass native `is_int` and `is_string` as condition
        $reflection = new \ReflectionFunction($condition);
        $hasTwoArguments = $reflection->getNumberOfParameters() === 2;
        foreach ($items as $key => $item) {
            $arguments = [$item];
            $hasTwoArguments && $arguments[] = $key;
            if (!\call_user_func($condition, ...$arguments)) {
                return false;
            }
        }
        return true;
    }

    public static function some(array $items, callable $condition): bool
    {
        // we need reflection to be able pass native `is_int` and `is_string` as condition
        $reflection = new \ReflectionFunction($condition);
        $hasTwoArguments = $reflection->getNumberOfParameters() === 2;
        foreach ($items as $key => $item) {
            $arguments = [$item];
            $hasTwoArguments && $arguments[] = $key;
            if (\call_user_func($condition, ...$arguments)) {
                return true;
            }
        }
        return false;
    }
}
