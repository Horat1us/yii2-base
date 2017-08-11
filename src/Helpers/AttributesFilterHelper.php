<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 11.08.17
 * Time: 13:00
 */

namespace Horat1us\Yii\Helpers;

/**
 * Class AttributesFilterHelper
 * @package Horat1us\Yii\Helpers
 */
class AttributesFilterHelper
{
    /**
     * @param array $attributes
     * @param callable[] $filters
     * @return array
     */
    public static function apply(array $attributes, array $filters) :array
    {
        foreach ($filters as $attribute => $filter) {
            if (!array_key_exists($attribute, $attributes)) continue;

            $attributes[$attribute] = $filter($attributes[$attribute]);
        }

        return $attributes;
    }
}