<?php

namespace Horat1us\Yii\Helpers;

use yii\db\Expression;

/**
 * Class QueryHelper
 * @package Horat1us\Yii\Helpers
 */
class QueryHelper
{
    /**
     * @param string $sqlMethod
     * @param mixed[] $params
     * @return Expression
     */
    public static function sqlCall(string $sqlMethod, ...$params)
    {
        $expressions = implode(', ', array_map(function ($expression) {
            return "({$expression})";
        }, $params[0] ?? []));

        $command = "{$sqlMethod}({$expressions})";

        return new Expression($command);
    }

    /**
     * Only for PostgreSQL
     *
     * @param array ...$params
     * @return Expression
     */
    public static function coalesce(...$params)
    {
        return static::sqlCall('COALESCE', $params);
    }
}