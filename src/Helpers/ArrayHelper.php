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
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newItems = $items;
                $newPerms = $perms;
                list($foo) = array_splice($newItems, $i, 1);
                array_unshift($newPerms, $foo);
                $return = array_merge($return, static::permute($newItems, $newPerms));
            }
        }
        return $return;
    }
}
