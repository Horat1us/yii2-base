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
    public static function sqlCall(string $sqlMethod, ...$params): Expression
    {
        $expressions = implode(', ', array_map(function ($expression) {
            return "({$expression})";
        }, (array)$params));

        $command = "{$sqlMethod}({$expressions})";

        return new Expression($command);
    }

    /**
     * Only for PostgreSQL
     *
     * @param array ...$params
     * @return Expression
     */
    public static function coalesce(...$params): Expression
    {
        return static::sqlCall('COALESCE', ...$params);
    }

    /**
     * @param array $cases
     * @param string|null $value
     * @param string|null $else
     * @return string
     */
    public static function caseWhen(array $cases, string $value = '', string $else = null): string
    {
        $command = "CASE {$value}";

        foreach ($cases as $condition => $statement) {
            $command .= " WHEN {$condition} THEN {$statement}";
        }

        if ($else) {
            $command .= " ELSE {$else}";
        }

        $command .= " END";

        return new Expression($command);
    }
}
